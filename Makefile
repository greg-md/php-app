serve:
	docker-compose up
test:
	docker-compose -f docker-compose-ci.yml up --build --abort-on-container-exit --exit-code-from app-ci
