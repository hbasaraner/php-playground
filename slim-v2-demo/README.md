# Slim Framework v2 API Demo

## API Methods

### GET

```
http://localhost/api/user/get/{id}
```

Returns a JSON with **Status: 302 Found** if user exists. Otherwise, returns *"User not found"* message with **Status: 204 No Content**

### POST

```
http://localhost/api/user/post
```

Returns with *"User added"* message with **Status: 201 Created** if user created successfully. Otherwise, it returns *"Fill all the blanks"* or *"Invalid mail"* or *"Invalid username"* message with **Status: 400 Bad Request**

### PUT

```
http://localhost/api/user/update/{id}
```

Returns with *"User ID: **{id}** is updated."*  message with **Status: 200 OK** if user updated successfully. Otherwise, it returns *"User not found"*  message with **Status: 204 No Content** or *"Invalid mail"* message with **Status: 400 Bad Request**

### DELETE

```
http://localhost/api/user/delete/{id}
```

Returns with "User ID: **{id}** is deleted" message with Status: 400 Gone if user deleted successfully. Otherwise, it returns "User not found" message with **Status: 204 No Content**