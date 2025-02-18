# Yohann Bianchi - Roadsurfer coding task

Implementation of the coding task described [here](./task-readme.md).


## Tech stack

- PHP 8.4
- Symfony 7.2
- MariaDB 10.11


## Project setup

You'll need Docker & [DDEV](https://ddev.com/get-started/) to run the project.

- run the following commands to start the project:

  ```bash
  ddev start
  ddev composer install
  ddev console doctrine:schema:create
  ```

✨ The API is available at <https://roadsurfer-coding-task.ddev.site/>


## Documentation

### Import command

Run the following command to import data into the database:

```bash
ddev console app:import:edibles tests/Resources/request.json
```

### API

A REST API is exposed at <https://roadsurfer-coding-task.ddev.site/api/edibles>.

There is a [Bruno collection](.bruno) that offers ready-to-run requests.

#### `GET /api/edibles`

Get all items.

#### `GET /api/edibles/{id}`

Get a single item by id.

#### `POST /api/edibles`

Create an item.

Example payload:

```json
{
  "name": "Mango",
  "quantity": 560,
  "unit": "g",
  "type": "fruit"
}
```

#### `DELETE /api/edibles/{id}`

Delete a single item by id.


## Running tests

Run the following command to run tests:

```bash
ddev composer run test
```
