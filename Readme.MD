# UserAPI Endpoint Setup Guide

## How to Setup

1. **Clone the repository**:
    ```
    git clone https://github.com/yusuf-mutlu/UserAPIEndpoint.git
2. **Change to the project directory**:
    ```
    cd UserAPIEndPoint
3. **Install required packages**:
    ```
    composer install
4. **Environment configuration**:
- Create a new file named `.env.local`.
- Copy the contents from `.env` to `.env.local`.
- Don't forget to setup `DATABASE_URL` in `.env.local`.

5. **Database schema creation**:
- To create the schema for development:
  ```
  php bin/console doctrine:schema:create
  ```
- To create the schema for API testing:
  ```
  php bin/console doctrine:schema:create --env=test
  ```

## Usage

### Creating a User
```bash
curl -X POST "http://127.0.0.1:8000/api/users" \
  -H "Content-Type: application/ld+json" \
  -d '{
        "firstName": "John",
        "lastName": "Doe",
        "dateOfBirth": "1990-01-01",
        "email": "john.doe@example.com"
      }' 
```

### Retrieve All Users
```bash
curl -X GET "http://127.0.0.1:8000/api/users"
```
### Retrieve a Single User
```bash
curl -X GET "http://127.0.0.1:8000/api/users/1"
```
### Update User Data
```bash
curl -X PUT "http://127.0.0.1:8000/api/users/1" \
     -H "Content-Type: application/ld+json" \
     -d '{
            "firstName": "Joseph",
            "lastName": "Smith",
            "dateOfBirth": "1990-01-01",
            "email": "joseph.smith@example.com"
        }'
```
### Update Partial User Data
```bash
curl -X PATCH "http://127.0.0.1:8000/api/users/1" \
     -H "Content-Type: application/merge-patch+json" \
     -d '{
            "email": "joseph.smith2@example.com"
        }'
```
### Delete a User
```bash
curl -X DELETE "http://127.0.0.1:8000/api/users/1"
```
