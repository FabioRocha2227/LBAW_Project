## A7: Web Resources Specification
This artifact documents the  architecture of the web application to be developed, indicating the catalog of resources, the properties of each resource, and the format of JSON responses.

### 1. Overview
An overview of the web application to implement is presented in this section, where the modules are identified and briefly described.
| Module | Description |
| -------------------- | ---------------------- |
| M01: Authentication and Individual Profile| Web resources associated with user authentication and individual profile management. Includes the following system features: login/logout, registration, view and edit personal profile information.|
| M02: Publishing posts, comments and reacts | Web resources associated with posting, reacting and commenting. Includes the following system features: publishing a post, comment a post, react to a post/comment, delete post/comment/react. |
| M03: Friendship | Web resources associated with friendship among users. Includes the following system features: send friend request, accept friend request, delete friendship. |
| M04: Groups | Web resourses associated with groups of users. Includes the following system features: create group, invite users to group, activity associated with M02 module but inside the group only, delete group (group owner only) and kick user from group (group owner only).| 
| M05: User Administration and Static pages | Web resources associated with user management and static pages, specifically: view and search users, delete or block user accounts, delete posts/comments/reacts and delete groups. Web resources with static content are associated with this module: about, faq.|


### 2. Permissions
This section defines the permissions used in the modules to establish the conditions of access to resources.
| Abbreviation| Name | Description |
| ----------- | ---- | ----------- |
| PUB | Public | Users without privileges |
| USR | User | Authenticated users |
| OWN | Owner | User that are owners of the information (e.g. own profile, post, comment, react, group)| 
| ADM | Admin | System administrators |

### 3. OpenAPI Specification

> OpenAPI specification in YAML format to describe the vertical prototype's web resources.

> Link to the `a7_openapi.yaml` file in the group's repository.


```yaml
openapi: 3.0.0

info:
 version: '1.0'
 title: 'LBAW Usless Web API'
 description: 'Web Resources Specification (A7) for Usless'

servers:
- url: 
 description: Production server

externalDocs:
 description: Find more info here.
 url: 

tags:
 - name: 'M01: Authentication and Individual Profile'
 - name: 'M02: Publishing posts, comments and reacts'
 - name: 'M03: Friendship'
 - name: 'M04: Groups'
 - name: 'M05: User Administration and Static pages'



paths:
  /login:
   get:
     operationId: R01
     summary: 'R01: Login Form'
     description: 'Provide login form.'
     tags:
       - 'M01: Authentication and Individual Profile'
     responses:
       '200':
         description: 'Show Log-in'
   post:
     operationId: R02
     summary: 'R02: Login Action'
     description: 'Processes the login form submission.'
     tags:
       - 'M01: Authentication and Individual Profile'  

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               email:          
                 type: string
               password:    
                 type: string
             required:
                  - email
                  - password
     responses:
                '302':
                    description: 'Redirect after login'
                    headers:
                      Location:
                        schema:
                          type: string
                        examples:
                          302Success:
                              description: 'Ok. Redirect to Home Page'
                              value: '/cards'
                          302Error:
                              description: 'Failed Authentication. Redirect to login form.'
                              value: '/login'

  /logout:
        post:
            operationId: R03
            summary: 'R03: Logout Action'
            description: 'Logout the current authenticated user. Access: USR'
            tags:
                - 'M01: Authentication and Profile'
            responses:
                '302':
                    description: 'Redirect after processing logout.'
                    headers:
                        Location:
                          schema:
                            type: string
                          examples:
                              302Success:
                                  description: 'Successful logout. Redirect to homepage.'
                                  value: '/login'

 /register:
        get:
            operationId: R04
            summary: 'R04: Register Form '
            description: 'Provide signup form. Access: PUB'
            tags:
              - 'M01: Authentication and Profile'
            responses:
              '200':
                description: 'Ok. Show sign-up form UI.'

        post:
            operationId: R05
            summary: 'R05: Register Action'
            description: 'Signup to the website'
            tags:
                - 'M01: Authentication and Profile'
            
            requestBody:
                    required: True
                    content:
                        application/x-www-form-urlencoded:
                            schema:
                                type: object
                                properties:
                                    username:
                                        type: string
                                    email:
                                        type: string
                                    password:
                                        type: string
                                required:
                                    - username
                                    - email
                                    - password
            responses:
                '302':
                    description: 'Redirect after processing signup credentials.'
                    headers:
                      Location:
                        schema:
                          type: string
                        examples:
                            302Success:
                                description: 'Successful credential insertion.Redirect to user'
                                value: '/username/{id}'
                            302Error: 
                                description: 'Failed credential insertion. Redirect to signup form'
                                value: '/register'

     /profileShow/{username}:
          get:
            operationId: R06
            summary: 'R06: View Profile'
            description: 'Show the individual user profile. Access: USR'
          tags:
            - 'M01: Authentication and Individual Profile'

          parameters:
            -in: path
            name: username
            schema:
              type: string
            required: true

          responses:
            '200':
              description: 'Ok. Show User Profile UI'
  
     /postInsert:
       post:
        operationId: R08
        summary: 'R08: Publish Post'
        description: 'Insert a new Post. Access: USR'
        tags: 
          - 'M02: Publishing posts, comments and reacts'

        requestBody:
                required: True
                content:
                    application/x-www-form-urlencoded:
                        schema:
                            type: object
                            properties:
                                id:
                                    type: integer
                                id_user:
                                    type: integer
                                content:
                                    type: string
                                post_state:
                                    type: integer
                                post_date:
                                    type: string
                                id_groups:
                                    type: integer  
                            required:
                                - id
                                - id_user
                                - content
                                - post_state
                                - post_date
                                - id_groups
                responses:
                '200':
                  description: 'Ok. Post inserted'
    
      /postDelete/{id}:
        delete:
            operationId: R09
            summary: 'R09: Delete Post'
            description: 'Processes the deletion of a post. Access: USR' 
            tags: 
            - 'M02: Publishing posts, comments and reacts'

            parameters:
              - in: path
                name: id
                schema:
                  type: integer
                required: true


            responses:
                '302':
                    description: 'Redirect after deleting post'
                    headers:
                        Location:
                            schema:
                                type: string
                            examples:
                                302Success:
                                    description: 'Sucessfull deletion. Redirected to the specific question page.'
                                    value: '/cards'

        postUpdate/{id}:
                              
        post:
          operationId: R10
          summary: 'R10: Edit Post'
          description: 'Edit Post. Access: USR'
          tags: 
            - 'M02: Publishing posts, comments and reacts'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  id_user:
                                      type: integer
                                  content:
                                      type: string
                                  post_state:
                                      type: integer
                                  post_date:
                                      type: string
                                  id_groups:
                                      type: integer  
                              required:
                                  - id
                                  - id_user
                                  - content
                                  - post_date
                                 
                  responses:
                  '200':
                    description: 'Ok. Post edited'          

```


## A8: Vertical prototype
The Vertical Prototype includes the implementation of the features marked as necessary (with an asterisk) in the common and theme requirements documents.


### 1. Implemented Features

#### 1.1. Implemented User Stories
The user stories that were implemented in the prototype are described in the following table.  

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01                 | Log in | high | As a user, I want to authenticate into the system, so that I can participate actively. |
|US02|Sign up|high|As a user, I want to register into the system, so that I can set up my profile.|
|US03|Public Timeline|High|As a user, I want to view the public timeline, so that i can see what public authenticated users are publishing|
|US04|Public Profiles|High|As a user, I want to view public profiles of other users, so that I can see their information.|
|US05|Search Public Users|High|As a user, I want to search for public users, so that i can see their posts and profile.|
|US06|View Personalized Timeline|High|As an Authenticated User, I want to View Personalized Timeline, so that I can see what my Friends are posting.|
|US07|View User Profiles|High|As an Authenticated User, I want to see other users profiles, so that I can see their posts|
|US08|Create Post |High|As an Authenticated User, I want to Create Post, so that I can share with other users.|
|US09|Edit Post |High|As a post author, I want to edit my post, so that I can change the information it contains.|
|US10|Delete Post|High|As a post author, I want to delete my post, so that it's not in the system.|



#### 1.2. Implemented Web Resources

> Identify the web resources that were implemented in the prototype.  

> Module M01: Authentication and Individual Profile

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R01:  Login Form  | GET/login |
| R02: Login Action | POST/login|
| R03: Logout Action|GET/logout|
| R04: Register Form |GET/register|
| R05: Register Action |POST/register|
| R06: View Profile|GET/profileShow/{username}|
| R06: View Notifications|GET/notifications|
| R07: View Settings|GET/settings|
| R07: View Messages|GET/messages|

> M02: Publishing posts, comments and reacts
| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R08: Publish Post|POST/postInsert|
| R09: Delete Post|DELETE/postDelete/{id}|
| R10: Edit Post|POST/postUpdate/{id} |

> M05: User Administration and Static pages 
| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R11: View other user Profile| GET/profileShow/{username}|
| R12:Search User Porfile| POST/profileShow|


### 2. Prototype

#### Credentials
    adim@example.com
    1234

    rafa@example.com
    1234
#### Link to production version

http://lbaw2273.lbaw.fe.up.pt/


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2273, 325/11/2022
 
* Rafael Cerqueira, up201910200@up.pt

* Fábio Rocha, up202005478@up.pt

* José Carvaho, up202005827@up.pt
