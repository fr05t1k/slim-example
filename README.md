## Description
This service stores information from an external provider (e.x. facebook).

## Getting start

1. Copy `.env.example` to `.env`
1. Run `./bin/run up` (docker is requirement)
1. `127.0.0.1:8080/store` (`docker-machine-ip:8080/store` if you're using docker-machine)

## Usage

### Endpoints
#### HTTP
* `/store?token={token}` stores user's information from this token
#### Console
* `./bin/run console user-info:store -t {token}` stores user's information from this token
### Console helper
* `./bin/run up` start application
* `./bin/run down` stop application
* `./bin/run console` run console scripts
* `./bin/run test` run tests
* `./bin/run test tests/Test.php` run an particular test
* `./bin/run coverage ` run code coverage
