make deploy -M=updated:
	git add .
	git commit -m "${M}"
	git push origin main