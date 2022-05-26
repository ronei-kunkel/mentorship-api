
# API

## Endpoint

`https://feeltech-mentorship-api.herokuapp.com/api`

## Resources

- `/brand` - partially done
- `/category` - partially done
- `/promotion` - wip
- `/product` - in near future

## Methods

- GET

  - `/{{resource}}` - return all data of resource:

    - Have registers:

      Status code: 200

      ```json
      {
        "success": true,
        "{{resource}}": [
          {"..."},
          {"..."}
        ]
      }
      ```

    - Don't have registers:

      Status code: 404

        ```json
        {
          "success": true,
          "message": "There are no data from {{resource}} yet",
          "{{resource}}": []
        }
        ```

    - When error occurs:

      Status code: Relative to error based on [HTTP response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status) of Mozilla

        ```json
        {
          "success": false,
          "message": "Report of error"
        }
        ```

  - `/{{resource}}/{{id}}` - return specific resource

    - Have register:

      Status code: 200

      ```json
      {
        "success": true,
        "{{resource}}": [
          {"..."}
        ]
      }
      ```

    - Don't have register:

      Status code: 404

        ```json
        {
          "success": true,
          "message": "Not found this specific {{resource}}",
          "{{resource}}": []
        }
        ```

    - When error occurs:

      Status code: Relative to error based on [HTTP response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status) of Mozilla

        ```json
        {
          "success": false,
          "message": "Report of error"
        }
        ```

- POST

  - `/{{resource}}` - create specific resource

    - Success:

      Status code: 201

      ```json
      {
        "success": true,
        "{{resource}}": [
          {
            "id": "{{id}}",
            "..."
          }
        ]
      }
      ```

    - Missed one or more values:

      Status code: 400

      ```json
      {
          "success": false,
          "message": "Any or more values are missing",
          "values": ["{{value}}", "{{value}}"]
        }
      ```

    - When error occurs:

      Status code: Relative to error based on [HTTP response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status) of Mozilla

        ```json
        {
          "success": false,
          "message": "Report of error"
        }
        ```

- PUT

  - `/{{resource}}/{{id}}` - update partially or completelly specific resource

    - When one or more values are updated:

      Status code: 200

      ```json
      {
        "success": true,
        "message": "Updated",
        "newData": [
          {"..."}
        ],
        "oldData": [
          {"..."}
        ]
      }
      ```

    - When there is nothing to update:

      Status code: 202

      ```json
      {
        "success": true,
        "message": "Nothing to update"
      }
      ```

    - When error occurs:

      Status code: Relative to error based on [HTTP response status codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status) of Mozilla

        ```json
        {
          "success": false,
          "message": "Report of error"
        }
        ```

        <!-- falta tratar quando há uma atualização para um recurso que ainda não existe (uma marca que não foi criada ainda) -->

- DELETE

  - `/{{resource}}/{{id}}` - delete specific resource

    - NEED DOCUMENTATION

## Returns

```json
{
  "success": true false,  // success of the request to the resource of api
  "message": "string",    // feedback of the requested resource
  "{{resource}}": [{"..."}] // requested resource data when success true
}
```

<!-- ### Real examples

- When don't have brands:

  ```json
  {
    "success": true,
    "brand": []
  }
  ```

- When have brands:

  ```json
  {
    "success": true,
    "brand": [
      {
        "id": 1,
        "name": "Brand One",
        "description": "Generic description from Brand One"
      },
      {
        "id": 2,
        "name": "Brand Two",
        "description": "Generic description from Brand Two"
      }
    ]
  }
  ```

- When have error in request:

  ```json
  {
    "success": false,
    "message": "Brand with id 0 don't exist!"
  }
  ``` -->
