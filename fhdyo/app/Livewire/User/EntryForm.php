<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Services\JshshirService;
use App\Http\Requests\User\UserEntryRequest;
use App\Models\TestSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EntryForm extends Component
{
    public string $my_jshshir = '';
    public string $partner_jshshir = '';
    public string $category = 'nikoh';
    public bool $isProcessing = false;

    protected JshshirService $jshshirService;

    protected function rules(): array
    {
        return [
            'category' => ['required', 'in:nikoh,ajrim'],
            'my_jshshir' => [
                'required',
                'string',
                'digits:14',
                'different:partner_jshshir',
                function ($attribute, $value, $fail) {
                    if (!$this->jshshirService->validateJshshir($value)) {
                        $fail('JSHSHIR noto\'g\'ri formatda yoki noto\'g\'ri tekshirish raqamiga ega.');
                    }
                    if (!$this->jshshirService->isAdult($value)) {
                        $fail('Sizning JSHSHIRingiz 18 yoshdan kichikni ko\'rsatadi. Test faqat 18 yoshdan kattalar uchun.');
                    }
                },
            ],
            'partner_jshshir' => [
                'required',
                'string',
                'digits:14',
                'different:my_jshshir',
                function ($attribute, $value, $fail) {
                    if (!$this->jshshirService->validateJshshir($value)) {
                        $fail('Sherikning JSHSHIRi noto\'g\'ri formatda yoki noto\'g\'ri tekshirish raqamiga ega.');
                    } elseif (!$this->jshshirService->isAdult($value)) {
                        $fail('Sherigingizning JSHSHIRi 18 yoshdan kichikni ko\'rsatadi. Test faqat 18 yoshdan kattalar uchun.');
                    } else {
                        // Format va yosh to'g'ri bo'lsa, Jinsni tekshiramiz
                        if (!empty($this->my_jshshir) && $this->jshshirService->validateJshshir($this->my_jshshir)) {
                            $myGender = $this->jshshirService->detectGender($this->my_jshshir);
                            $partnerGender = $this->jshshirService->detectGender($value);
                            
                            if ($myGender === $partnerGender) {
                                $fail('Ikkala JSHSHIR ham bir xil jins vakilini ko\'rsatadi. Test uchun turli jins vakillari kerak.');
                            }
                        }
                    }
                },
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'category.required' => 'Test turini tanlang.',
            'category.in' => 'Test turi nikoh yoki ajrim bo\'lishi kerak.',
            'my_jshshir.required' => 'Sizning JSHSHIRingizni kiriting.',
            'my_jshshir.digits' => 'JSHSHIR 14 ta raqamdan iborat bo\'lishi kerak.',
            'my_jshshir.different' => 'Sizning JSHSHIRingiz va sherigingizning JSHSHIRi bir xil bo\'lmasligi kerak.',
            'partner_jshshir.required' => 'Sherigingizning JSHSHIRini kiriting.',
            'partner_jshshir.digits' => 'Sherigingizning JSHSHIRi 14 ta raqamdan iborat bo\'lishi kerak.',
            'partner_jshshir.different' => 'Sherigingizning JSHSHIRi va sizning JSHSHIRingiz bir xil bo\'lmasligi kerak.',
        ];
    }

    public function boot(JshshirService $jshshirService): void
    {
        $this->jshshirService = $jshshirService;
    }

    public function submit(): void
    {
        $this->isProcessing = true;

        try {
            $this->validate();

            // Get or create users
            $initiator = $this->jshshirService->getOrCreateUser($this->my_jshshir);
            $partner = $this->jshshirService->getOrCreateUser($this->partner_jshshir);

            // Check if session already exists
            $existingSession = TestSession::where(function ($query) use ($initiator, $partner) {
                $query->where('initiator_id', $initiator->id)
                      ->where('partner_id', $partner->id);
            })->orWhere(function ($query) use ($initiator, $partner) {
                $query->where('initiator_id', $partner->id)
                      ->where('partner_id', $initiator->id);
            })->first();

            if ($existingSession) {
                // Store the user's JSHSHIR in session for identification
                session(['user_jshshir' => $this->my_jshshir]);
                $this->redirectRoute('user.test.show', $existingSession->id);
                return;
            }

            // Create new test session with selected category
            $testSession = $this->jshshirService->createTestSession($initiator, $partner, $this->category);

            // Store the user's JSHSHIR in session for identification
            session(['user_jshshir' => $this->my_jshshir]);
            
            $this->redirectRoute('user.test.show', $testSession->id);

        } catch (ValidationException $e) {
            $this->isProcessing = false;
            throw $e;
        } catch (\Exception $e) {
            $errorMessage = 'Xatolik yuz berdi. Iltimos, qayta urinib ko\'ring.';
            
            // Check for specific database errors
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $errorMessage = 'Bu JSHSHIR allaqachon ro\'yxatdan o\'tgan.';
            } elseif (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $errorMessage = 'Ma\'lumotlarni saqlashda xatolik yuz berdi.';
            }
            
            $this->addError('my_jshshir', $errorMessage);
            $this->isProcessing = false;
        }
    }

    public function updatedMy_jshshir(): void
    {
        $this->resetValidation('my_jshshir');
        $this->my_jshshir = preg_replace('/[^0-9]/', '', $this->my_jshshir);
        
        // Check gender validation in real-time
        $this->validateGender();
    }

    public function updatedPartner_jshshir(): void
    {
        $this->resetValidation('partner_jshshir');
        $this->partner_jshshir = preg_replace('/[^0-9]/', '', $this->partner_jshshir);
        
        // Check gender validation in real-time
        $this->validateGender();
    }

    private function validateGender(): void
    {
        if (!empty($this->my_jshshir) && !empty($this->partner_jshshir) &&
            strlen($this->my_jshshir) === 14 && strlen($this->partner_jshshir) === 14 &&
            $this->jshshirService->validateJshshir($this->my_jshshir) &&
            $this->jshshirService->validateJshshir($this->partner_jshshir)) {
            
            // Check age validation
            if (!$this->jshshirService->isAdult($this->my_jshshir)) {
                $this->addError('my_jshshir', 'Sizning JSHSHIRingiz 18 yoshdan kichikni ko\'rsatadi. Test faqat 18 yoshdan kattalar uchun.');
                return;
            }
            
            if (!$this->jshshirService->isAdult($this->partner_jshshir)) {
                $this->addError('partner_jshshir', 'Sherigingizning JSHSHIRi 18 yoshdan kichikni ko\'rsatadi. Test faqat 18 yoshdan kattalar uchun.');
                return;
            }
            
            // Check gender validation
            $myGender = $this->jshshirService->detectGender($this->my_jshshir);
            $partnerGender = $this->jshshirService->detectGender($this->partner_jshshir);
            
            if ($myGender === $partnerGender) {
                $this->addError('partner_jshshir', 'Ikkala JSHSHIR ham bir xil jins vakilini ko\'rsatadi. Test uchun turli jins vakillari kerak.');
            }
        }
    }

    public function render()
    {
        return view('livewire.user.entry-form');
    }
}
