# PA: Product and Presentation

> Project vision.

## A9: Product

Useless is a social media platform that aims to unite and promote communication. Through the creation of publications, users are able to share their experiences with their friends and ask them to comment and engage with them.
Groups promote activities and exchanges with like-minded individuals. 

### 1. Installation

> Link to the release with the final version of the source code in the group's Git repository.  
> Include the full Docker command to start the image available at the group's GitLab Container Registry using the production database.  

### 2. Usage

> URL to the product: http://lbaw2273.lbaw.fe.up.pt  
 

#### 2.1. Administration Credentials

> Administration URL: URL  

| Username | Password |
| -------- | -------- |
| admin@example.com   | 1234 |

#### 2.2. User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| basic account | jonny@example.com   | 1234  |
| basic account | marta@example.com   | 1234  |

### 3. Application Help

> Describe where help has been implemented, pointing to working examples.  

### 4. Input Validation

When on the client side, the input has been validated through HTML parameters for example, the email parameters either in register or login must follow the structure of a email, or it will not be accepted. As for the server side, Larable's Validation capabilities were used, for example, to confirm that the password contains the necessary characters and that the email address is unique.

### 5. Check Accessibility and Usability

 The PDF files are included in the submitted ZIP file on Moodle.

 Accessibility: 14/18
 Usability: 23/28

### 6. HTML & CSS Validation

Two HTML files and two CSS files were tested. Some errors were found in the HTML file, unlike the css file where no errors were found.
Both validations are attached

### 7. Revisions to the Project

> Describe the revisions made to the project since the requirements specification stage.  


### 8. Web Resources Specification

> Updated OpenAPI specification in YAML format to describe the final product's web resources.

> Link to the `a9_openapi.yaml` file in the group's repository.


```yaml
openapi: 3.0.0
info:
 version: '2.0'
 title: 'LBAW Usless Web API'
 description: 'Final'

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
                description: 'Ok. Show sign-up form UI.

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

       /password/reset:
        get:
            operationId: R33
            summary: 'R33: Reset password '
            description: 'Passord recovery. Access: PUB'
            tags:
              - 'M01: Authentication and Profile'
            responses:
              '200':
                description: 'Ok. Password reseting.'

      /password/email:
       post:
        operationId: R34
        summary: 'R34: Send email'
        description: 'Send email with token: USR'
        tags: 
          - 'M01: Authentication and Profile'

        requestBody:
                required: True
                content:
                    application/x-www-form-urlencoded:
                        schema:
                            type: object
                            properties:
                                email:
                                    type: string
                                token:
                                    type: string
                            required:
                                - email
                responses:
                '200':
                  description: 'Ok. Email sent'
                '404'
                  description: 'ERROR'  

      /password/reset/{token}:
        get:
            operationId: R35
            summary: 'R35: token '
            description: 'Token. Access: PUB'
            tags:
              - 'M01: Authentication and Profile'
            responses:
              '200':
                description: 'Ok. Confirm token.'


      /password/email:
        post:
            operationId: R36
            summary: 'R36: Reset Password'
            description: 'Reset Password. Acess: USR'
            tags: 
              - 'M01: Authentication and Profile'

            requestBody:
                    required: True
                    content:
                        application/x-www-form-urlencoded:
                            schema:
                                type: object
                                properties:
                                    email:
                                        type: string
                                    token:
                                        type: string
                                    password:
                                        type: string    
                                required:
                                    - email
                                    - token
                                    - password
                    responses:
                    '200':
                      description: 'Ok. Password reseted'
                    '404'
                      description: 'Token does not match' 

     /profilepage/{id_user}:
          get:
            operationId: R06
            summary: 'R010: View Users Profile'
            description: 'Show the user profile. Access: USR'
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
              description: 'Ok. Show User's Profile UI'


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

       /commentInsert/{id_post}:
        post:
          operationId: R11
          summary: 'R1: Publish Comment'
          description: 'Insert a new Comment. Access: USR'
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
                                  content:
                                      type: string
                                  id_user:
                                      type: integer
                                  id_post:
                                      type: integer
                                  comment_date:
                                      type: integer
                                  comment_state:
                                      type: integer  
                              required:
                                  - id
                                  - content
                                  - id_user
                                  - id_post
                                  - comment_date
                                  - comment_state
                  responses:
                  '200':
                    description: 'Ok. Comment inserted'

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
       /CommentDelete/{id}:
        delete:
            operationId: R12
            summary: 'R12: Delete Comment'
            description: 'Processes the deletion of a comment. Access: USR' 
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
                    description: 'Redirect after deleting comment'
                    headers:
                        Location:
                            schema:
                                type: string
                            examples:
                                302Success:
                                    description: 'Sucessfull deletion. Redirected to the specific question page.'
                                    value: '/cards'                             

        /postUpdate/{id}:
                              
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


      /react_post/{id_user}{id_post}{user_to}:
                              
        post:
          operationId: R13
          summary: 'R13: React Post'
          description: 'React Post. Access: USR'
          tags: 
            - 'M02: Publishing posts, comments and reacts'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_react_post:
                                      type: integer
                                  id_user:
                                      type: integer
                                  react_post_date:
                                      type: integer
                                  id_post:
                                      type: integer
                                  user_to:
                                      type: integer
                              required:
                                  - id_react_post
                                  - id_user
                                  - react_post_date
                                  - id_post
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Post reacted'       

      /react_post_delete/{id_user}{id_post}{user_to}:
                              
        post:
          operationId: R13
          summary: 'R13: Delete React Post'
          description: 'Delete React Post. Access: USR'
          tags: 
            - 'M02: Publishing posts, comments and reacts'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_react_post:
                                      type: integer
                                  id_user:
                                      type: integer
                                  react_post_date:
                                      type: integer
                                  id_post:
                                      type: integer
                                  user_to:
                                      type: integer
                              required:
                                  - id_react_post
                                  - id_user
                                  - id_post
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Deleted Post reacted'

      /react_comment/{id_user}{id_comment}{user_to}:
                              
        post:
          operationId: R14
          summary: 'R14: React Comment'
          description: 'React Comment. Access: USR'
          tags: 
            - 'M02: Publishing posts, comments and reacts'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_react_comment:
                                      type: integer
                                  id_user:
                                      type: integer
                                  react_comment_date:
                                      type: integer
                                  id_comment:
                                      type: integer
                                  user_to:
                                      type: integer
                              required:
                                  - id_react_post
                                  - id_user
                                  - react_post_date
                                  - id_post
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Comment reacted'

      /react_comment_delete/{id_user}{id_comment}{user_to}:
                              
        post:
          operationId: R15
          summary: 'R15: Delete React Comment'
          description: 'Delete React Comment. Access: USR'
          tags: 
            - 'M02: Publishing posts, comments and reacts'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_react_comment:
                                      type: integer
                                  id_user:
                                      type: integer
                                  react_comment_date:
                                      type: integer
                                  id_comment:
                                      type: integer
                                  user_to:
                                      type: integer
                              required:
                                  - id_react_comment
                                  - id_user
                                  - id_comment
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Deleted Comment reacted'

      /friend_request/{user_from}{user_to}:
                              
        post:
          operationId: R16
          summary: 'R16: Add Friend'
          description: 'Add Friend. Access: USR'
          tags: 
            - 'M03: Friendship'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  user_from:
                                      type: integer
                                  user_to:
                                      type: integer
                                  requested:
                                      type: integer
                              required:
                                  - user_from
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Friend Request Sent'

      /accept_request/{id}:
                              
        post:
          operationId: R17
          summary: 'R17: Accept Friend'
          description: 'Accept Friend. Access: USR'
          tags: 
            - 'M03: Friendship'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  user_from:
                                      type: integer
                                  user_to:
                                      type: integer
                                  requested:
                                      type: integer
                                  refused:
                                      type: integer   
                              required:
                                  - id
                                  - user_from
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Friend Request Accepted'

      /accept_request/{id}:
                              
        post:
          operationId: R18
          summary: 'R18: Reject Friend'
          description: 'Reject Friend. Access: USR'
          tags: 
            - 'M03: Friendship'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  user_from:
                                      type: integer
                                  user_to:
                                      type: integer
                                  requested:
                                      type: integer
                                  refused:
                                      type: integer   
                              required:
                                  - id
                                  - user_from
                                  - user_to
                                 
                  responses:
                  '200':
                    description: 'Ok. Friend Request Rejected' 

      /unfriend/{user_from}{user_to}:
                              
        get:
          operationId: R19
          summary: 'R19: Unfriend'
          description: 'Unfriend. Access: USR'
          tags: 
            - 'M03: Friendship'  
                  responses:
                  '200':
                    description: 'Ok. Unfriended'                         

      /groups:

        get:
          operationId: R20
          summary: 'R20: View Groups'
          description: 'View Groups.Access: USR'
          tags:
            - 'M04: Groups'
          responses:
            '200':
              description: 'Show Available groups'

      /groupspage/{id_group}:

        get:
          operationId: R21
          summary: 'R21: View Group page'
          description: 'View Groups page.Access: USR'
          tags:
            - 'M04: Groups'
          responses:
            '200':
              description: 'Show Group page'   
            '404'
              description: 'Group not found'    

      /groupleave/{id_group}:

        get:
          operationId: R22
          summary: 'R22: Leave Group'
          description: 'Leave Group.Access: USR'
          tags:
            - 'M04: Groups'
          responses:
            '200':
              description: 'Leave Group'   
            '404'
              description: 'Frobiden'

      /groupdelete/{id_group}:
                              
        post:
          operationId: R23
          summary: 'R23: Delete Group'
          description: 'Eliminate Grup. Access: OWN'
          tags: 
            - 'M04: Groups'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_groups:
                                      type: integer
                                  group_state:
                                      type: integer
                              required:
                                  - id_groups
                                  - group_state
                                 
                  responses:
                  '200':
                    description: 'Ok. Group deleted'

      /register_group:
                              
        post:
          operationId: R24
          summary: 'R24: Create Group'
          description: 'Create Grup. Access: USR'
          tags: 
            - 'M04: Groups'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_groups:
                                      type: integer
                                  group_description:
                                      type: string
                                  group_state:
                                      type: integer
                                  group_date:
                                      type: integer
                                  id_owner:
                                      type: integer    
                              required:
                                  - id_groups
                                  - group_state
                                  - group_description
                                  - group_date
                                 
                  responses:
                  '200':
                    description: 'Ok. Group deleted'

      /groupremove/{id_group}{id_user}:

        get:
          operationId: R25
          summary: 'R25: Remove user Group'
          description: 'Remove user from group.Access: OWN'
          tags:
            - 'M04: Groups'
          responses:
            '200':
              description: 'User removed'   
            '404'
              description: 'Error'

      /addmembergroup/{id_group}{id_user}:
                              
        post:
          operationId: R26
          summary: 'R26: Add member'
          description: 'Add member. Access: OWN'
          tags: 
            - 'M04: Groups'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  id_group:
                                      type: string
                                  id_user:
                                      type: integer   
                              required:
                                  - id_groups
                                  - id
                                  - id_user                                
                  responses:
                  '200':
                    description: 'Ok. Member added'  
      
      /postAdmin/{id}:
                              
        post:
          operationId: R27
          summary: 'R27: Post Admin'
          description: 'Post Admin. Access: ADM'
          tags: 
            - 'M05: User Administration and Static pages'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id:
                                      type: integer
                                  post_state:
                                      type: integer     
                              required:
                                  - id
                               
                  responses:
                  '200':
                    description: 'Ok. Post added'                  

      /admin:

        get:
          operationId: R28
          summary: 'R28: Admin page'
          description: 'Admin page.Access: ADM'
          tags:
            - 'M05: User Administration and Static pages'
          responses:
            '200':
              description: 'Page found'   
            '404'
              description: 'Forbiden'   

      /commentAdmin/{id}:
                              
        post:
          operationId: R29
          summary: 'R29: Comment Admin'
          description: 'Comment Admin. Access: ADM'
          tags: 
            - 'M05: User Administration and Static pages'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_comment:
                                      type: integer
                                  comment_state:
                                      type: integer     
                              required:
                                  - id_comment
                               
                  responses:
                  '200':
                    description: 'Ok. Comment added' 

      /groupunban/{id_group}:
                              
        post:
          operationId: R30
          summary: 'R30: Unban Group'
          description: 'Unban Group. Access: ADM'
          tags: 
            - 'M05: User Administration and Static pages'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  id_groups:
                                      type: integer
                                  group_state:
                                      type: integer     
                              required:
                                  - id_groups
                               
                  responses:
                  '200':
                    description: 'Ok. Group unbanned'

      /ban/{id_user}:
                              
        post:
          operationId: R31
          summary: 'R31: Ban'
          description: 'Ban user. Access: ADM'
          tags: 
            - 'M05: User Administration and Static pages'

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
                                    type:integer
                              required:
                                  - id
                                  - id_user
                               
                  responses:
                  '200':
                    description: 'Ok. User banned' 

      /unban/{id_user}:
                              
        post:
          operationId: R32
          summary: 'R32: Unban'
          description: 'unban user. Access: ADM'
          tags: 
            - 'M05: User Administration and Static pages'

          requestBody:
                  required: True
                  content:
                      application/x-www-form-urlencoded:
                          schema:
                              type: object
                              properties:
                                  $id_user:
                                      type: integer  
                              required:
                                  - $id_user
                               
                  responses:
                  '200':
                    description: 'Ok. User unbanned'                                                         
```

### 9. Implementation Details

#### 9.1. Libraries Used

We used the following libraries and frameworks:

- Bootstrap: an open source toolkit for developing with HTML, CSS, and JS.
- Laravel: a PHP Framework For Web Artisans.



#### 9.2 User Stories
 
#### 2.1. User
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
| US01 | Log in | High | José Carvaho |  100%  |
| US02 | Sign up | High |  José Carvaho|  100%  |
| US03 | Public Timeline | High |José Carvaho,Rafael Cerqueira | 100%  |
| US04 | Public Profiles | High | José Carvaho,Rafael Cerqueira | 100%  |
| US05 | Search Public Users| High | José Carvaho | 100%  |

#### 2.2. Authenticated User
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
| US06 | View Personalized Timeline | High |Rafael Cerqueira |100%|
|US07| View User Profiles | High | José Carvaho,Rafael Cerqueira|100%|
|US08| Search for Posts, Comments, Groups and Users|High|José Carvaho|50%|
|US09| Send Friend Requests | High |Rafael Cerqueira,Fábio Rocha|100%|
|US10|Manage Received Friend Requests|High|Rafael Cerqueira |100%|
|US11|Manage Friends|High|Rafael Cerqueira,Fábio Rocha|100%|
|US12|Create Post|High|José Carvaho,Rafael Cerqueira|100%|
|US13|Comment on Posts |High|José Carvaho,Rafael Cerqueira|100%|
|US14|React to Post|High|Rafael Cerqueira,José Carvaho|100%|
|US15|React to Comment|High|Rafael Cerqueira,José Carvaho|100%|
|US16|Create Group|High|Rafael Cerqueira,Fábio Rocha|100%|
|US17|Manage Group Invitations|High|Rafael Cerqueira,Fábio Rocha|100%|
|US18|View Friends Feed|Low| Rafael Cerqueira|100%|

#### 2.3. Post Author
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US19| Edit Post | High |José Carvaho |100%|
|US20| Delete Post | High | Rafael Cerqueira |100%|
|US37|Manage Post Visibility|Low|Rafael Cerqueira|100%|

#### 2.4. Comment Author
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US21| Edit Comment | High | José Carvaho |100%|
|US22| Delete Comment | High |Rafael Cerqueira |100%|

#### 2.5. Group Member
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US23| View Group's Members | High | José Carvaho,Rafael Cerqueira|100%|
|US24| Post on Group |  High |Rafael Cerqueira,José Carvaho |100%|
|US25| Leave Group | High | Rafael Cerqueira |100%|

#### 2.6. Group Owner
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US26| Edit Group Information | High | Fábio Rocha |100%|
|US27| Remove Member | High | Rafael Cerqueira |100%|
|US28| Add to Group | High |Rafael Cerqueira |100%|
|US29| Remove Post From Group | Low | Rafael Cerqueira,José Carvaho |100%|


#### 2.7. Notifications
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US30| Likes on Own Post | High | Rafael Cerqueira |100%|
|US31| Comments on Own Posts | High | Rafael Cerqueira,José Carvaho |100%|
|US32| Friend requests | High | Rafael Cerqueira,José Carvaho |100%|

#### 2.8. Administrator
| US Identifier | Name    | Priority                       | Team Members               | State  |
| ------------- | ------- | ------------------------------ | -------------------------- | ------ |
|US33|Remove Posts|Medium|Rafael Cerqueira,José Carvaho |100%|
|US34|Remove Coments|Medium| Rafael Cerqueira,José Carvaho|100%|
|US35|Search Profiles|Medium|Rafael Cerqueira,José Carvaho|100%|
|US36|Ban Users|Medium| Rafael Cerqueira,José Carvaho|100%|


## A10: Presentation
 

### 1. Product presentation

Useless is a social media platform that aims to unite and promote communication. Through the creation of publications, users are able to share their experiences with their friends and ask them to comment and engage with them.
Groups promote activities and exchanges with like-minded individuals. 
>
> URL to the product: http://lbaw2273.lbaw.fe.up.pt  


### 2. Video presentation

> Screenshot of the video 

![alt text](/docs/images/image.png)


## Revision history

GROUP2273, 02/01/2023
 
* Rafael Cerqueira, up201910200@up.pt

* Fábio Rocha, up202005478@up.pt

* José Carvaho, up202005827@up.pt