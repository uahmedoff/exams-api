# API documentation

[[_TOC_]]

## Authorization

### POST `/auth/login`

Parameters:

- phone (required)
- password (required)

Example:

```
{
	"phone": "901234567",
	"Password": "some_password"
}
```

### POST `/auth/logout`

without parameter

### POST `/auth/refresh`

without parameter

### POST `/auth/me`

without parameter

## Administration of Resources

### GET `/resource`

Get resources with questions

Parameters:

- type_id (optional, integer (Values: 1 - Video, 2 - Audio, 3 - Image, 4 - Text))
- level_id (optional, integer)
- is_active (optional, boolean)
- column (optional, sort for column, Values: "id", "created_at", "updated_at", "text", "level_id", "is_active")
- order (optional, order by, Values: "asc", "desc")

### POST `/resource`

Insert new resource

Parameters:

- type_id (required, integer (Values: 1 - Video, 2 - Audio, 3 - Image, 4 - Text))
- level_id (required, integer)
- src (optional, base64 encoded file, extension must be one of these: "mp4, mp3, jpg, png")
- text (optional, text)

### GET `/resource/{resource_id}`

Get resource with given resource_id

No parameters

### PUT `/resource/{resource_id}`

Edit resource

Parameters:

- type_id (optional, integer (Values: 1 - Video, 2 - Audio, 3 - Image, 4 - Text))
- level_id (optional, integer)
- src (optional, base64 encoded file, extension must be one of these: "mp4, mp3, jpg, png")
- text (optional, text)

### DELETE `/resource/{resource_id}`

Activte/Deactivate resource

## Administration of Questions

### GET `/question`

Get questions

Parameters:

- without_resource (optional, true - boolean)
- question (optional, text)
- level_id (optional, integer)
- type_id (optional, integer)
- category_id (optional, integer (Values: 1 - Easy, 2 - Medium, 3 - Difficult))
- is_active (optional, boolean)
- column (optional, sort for column, Values: "id", "created_at", "updated_at", "question", "level_id", "resource_id", "is_active")
- order (optional, order by, Values: "asc", "desc")

### POST `/question`

Insert new question

Parameters:

- question (required, text)
- level_id (required, integer)
- type_id (required, integer)
- category_id (optional, integer (Values: 1 - Easy, 2 - Medium, 3 - Difficult))
- resource_id (optional, integer)

### GET `/question/{question_id}`

Get question with given question_id

No parameters

### PUT `/question/{question_id}`

Edit question

Parameters:

- question (optional, text)
- level_id (optional, integer)
- type_id (optional, integer)
- resource_id (optional, integer)

### DELETE `/question/{question_id}`

Activte/Deactivate question
