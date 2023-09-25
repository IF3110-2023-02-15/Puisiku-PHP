.PHONY: run run-build stop stop-clear

run:
	docker-compose up -d
run-build:
	docker-compose up -d --build
stop:
	docker-compose down
stop-clear:
	docker-compose down -v
