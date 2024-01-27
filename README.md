# Project API Documentation

Welcome to the documentation 
brain pop api project.
This API provides endpoints for managing students, teachers, periods, grades, and their relationships. Below is a comprehensive guide on how to interact with various components of our API.

## Authentication

### Student Authentication

#### Login
- **Endpoint:** `POST /api/student/login`
- **Description:** Authenticate a student and obtain an access token. (jwt)

...

### Teacher Authentication

#### Login
- **Endpoint:** `POST /api/teacher/login`
- **Description:** Authenticate a teacher and obtain an access token. (jwt)

...

## CRUD Operations

### Students

#### Retrieve All Students
- **Endpoint:** `GET /api/students`
- **Description:** Get a list of all students.


- **Endpoint:** `GET /api/students/id`
- **Description:** Get a response with the student of which you requested
- 
- **Endpoint:** `post /api/students`
- **Description:** Creates a student 
- **Required params:** 
- {
- **username**:**unique**,string,max-length:255,
- **full_name**:string,max-length:255
- **password**:string,min-length:6
-  }


- **Endpoint:** `put /api/students/id`
- **Description:** Updates a student - allowed only to update full name.
- **Required params:**
- {
- **full_name**:string,max-length:255
-  }

- **Endpoint:** `delete /api/students/id`
- **Description:** Delete a student
- **Required params:**
- {
- **id**:id
-  }
- 
..........
- 
### Teachers

#### Retrieve All Teachers
- **Endpoint:** `GET /api/teachers`
- **Description:** Get a list of all teachers.


- **Endpoint:** `GET /api/teachers/id`
- **Description:** Get a response with the teacher of which you requested
-
- **Endpoint:** `post /api/teachers`
- **Description:** Creates a teacher
- **Required params:**
- {
- **username**:**unique**,string,max-length:255,
- **email**:**unique**,email
- **full_name**:string,max-length:255
- **password**:string,min-length:6
-  }


- **Endpoint:** `put /api/teachers/id`
- **Description:** Updates a teacher - allowed only to update full name or email.
- **Required params:**
- {
- **full_name**:string,max-length:255 **and or** email
-  }

- **Endpoint:** `delete /api/teachers/id`
- **Description:** Delete a teacher
- **Required params:**
- {
- **id**:id
-  }


- **Endpoint:** `get teachers/{teacherId}/periods`
- **Description:** Gets all periods of given teacher
- **Required params:**
- {
- **teacherId**:id
-  }


- **Endpoint:** `get teachers/{teacherId}/students`
- **Description:** Gets all students of given teacher via periods
- **Required params:**
- {
- **teacherId**:id
-  }



#### Retrieve All Periods by Teacher
- **Endpoint:** `GET /api/teachers/{teacherId}/periods`
- **Description:** Get all periods associated with a specific teacher.

...........

### Grades

#### CRUD Operations for Grades
- **Endpoints:**
    - `PUT /api/grades/{id}`
- **Description:** Updates the grade of a give student id
- **Required body params:** {grade:int,period_id:int}

...

### Periods

#### CRUD Operations for Periods
- **Endpoints:**
    - `GET /api/periods`
    - `GET /api/periods/{id}`
    - `POST /api/periods`
    - `PUT /api/periods/{id}`
    - `DELETE /api/periods/{id}`

...

#### Assign Student to Period
- **Endpoint:** `POST /api/periods/assign-student`
- **Description:** Assign a student to a period.

...

#### Remove Student from Period
- **Endpoint:** `DELETE /api/remove-student/{periodId}/{studentId}`
- **Description:** Remove a student from a period.

...

#### Retrieve All Students by Period
- **Endpoint:** `GET /api/periods/{periodId}/students`
- **Description:** Get all students associated with a specific period.

...

