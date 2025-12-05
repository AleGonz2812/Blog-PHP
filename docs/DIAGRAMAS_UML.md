# 📊 Diagramas UML - Blog CMS

> 💡 **Para visualizar**: Copia el código en [www.plantuml.com/plantuml](https://www.plantuml.com/plantuml/uml/)

---

## 1. 📦 Diagrama de Clases

```plantuml
@startuml

skinparam classAttributeIconSize 0

package "Models" {
    
    class Database {
        - instance : Database
        - conn : PDO
        --
        + getInstance() : Database
        + getConnection() : PDO
    }
    
    class User {
        - conn : PDO
        - table : string
        --
        + register(username, password, email) : bool
        + login(username, password) : bool
        + logout() : void
        + findByUsername(username) : array
        + findById(id) : array
        + isLoggedIn() : bool
        + getCurrentUser() : array
    }
    
    class Post {
        - conn : PDO
        - table : string
        + id : int
        + title : string
        + content : string
        + image : string
        + user_id : int
        --
        + create(title, content, userId, image) : int
        + getById(id) : array
        + getAll(limit, offset) : array
        + update(id, title, content, image) : bool
        + delete(id) : bool
        + count() : int
    }
    
    class FileUpload {
        - uploadDir : string
        - allowedExtensions : array
        - maxFileSize : int
        --
        + upload(file) : string
        + delete(fileName) : bool
        + getError() : string
    }
}

package "Controllers" {
    
    abstract class BaseController {
        # view(view, data, layout) : void
        # render(view, data, layout) : void
        # redirect(path) : void
        # requireAuth() : void
    }
    
    class AuthController {
        - userModel : User
        --
        + showLogin() : void
        + login() : void
        + showRegister() : void
        + register() : void
        + logout() : void
    }
    
    class HomeController {
        - postModel : Post
        - userModel : User
        --
        + index() : void
        + show(id) : void
    }
    
    class PostController {
        - postModel : Post
        --
        + create() : void
        + store() : void
        + edit(id) : void
        + update(id) : void
        + delete(id) : void
    }
}

package "Routing" {
    
    class Router {
        - routes : array
        --
        + get(path, callback) : void
        + post(path, callback) : void
        + run() : void
        + redirect(path) : void
    }
}

Database <.. User
Database <.. Post
BaseController <|-- AuthController
BaseController <|-- HomeController
BaseController <|-- PostController
User <-- AuthController
User <-- HomeController
Post <-- HomeController
Post <-- PostController
FileUpload <-- PostController

@enduml
```

---

## 2. 🔄 Diagrama de Secuencia - Login

```plantuml
@startuml

actor Usuario
participant Router
participant AuthController
participant User
database MySQL

Usuario -> Router : POST /login
Router -> AuthController : login()
AuthController -> AuthController : Validar campos
AuthController -> User : login(username, password)
User -> MySQL : SELECT * FROM users
MySQL --> User : userData
User -> User : password_verify()

alt Credenciales correctas
    User --> AuthController : true
    AuthController -> Router : redirect('/')
    Router --> Usuario : Ir a Home
else Credenciales incorrectas
    User --> AuthController : false
    AuthController -> Router : redirect('/login')
    Router --> Usuario : Volver a Login
end

@enduml
```

---

## 3. 🔄 Diagrama de Secuencia - Crear Post

```plantuml
@startuml

actor Usuario
participant Router
participant PostController
participant FileUpload
participant Post
database MySQL

Usuario -> Router : POST /posts/store
Router -> PostController : store()
PostController -> PostController : requireAuth()
PostController -> PostController : Validar datos

opt Si hay imagen
    PostController -> FileUpload : upload(imagen)
    FileUpload -> FileUpload : Validar archivo
    FileUpload --> PostController : filename
end

PostController -> Post : create(title, content, userId, image)
Post -> MySQL : INSERT INTO posts
MySQL --> Post : postId
Post --> PostController : postId
PostController -> Router : redirect('/post/id')
Router --> Usuario : Ver post creado

@enduml
```

---

## 4. 🏗️ Diagrama de Componentes - Arquitectura MVC

```plantuml
@startuml

package "Cliente" {
    [Navegador Web]
}

package "public/" {
    [index.php] as index
    [.htaccess]
}

package "app/" {
    
    package "Controladores" {
        [BaseController]
        [AuthController]
        [HomeController]
        [PostController]
    }
    
    package "Modelos" {
        [Database]
        [User]
        [Post]
        [FileUpload]
    }
    
    package "Vistas" {
        [layouts/main.php]
        [auth/login.php]
        [auth/register.php]
        [posts/index.php]
        [posts/show.php]
    }
    
    [Router]
}

database "MySQL" {
    [blog_php]
}

[Navegador Web] --> [.htaccess]
[.htaccess] --> [index.php]
[index.php] --> [Router]
[Router] --> [AuthController]
[Router] --> [HomeController]
[Router] --> [PostController]
[AuthController] --> [User]
[HomeController] --> [Post]
[HomeController] --> [User]
[PostController] --> [Post]
[PostController] --> [FileUpload]
[User] --> [Database]
[Post] --> [Database]
[Database] --> [blog_php]
[AuthController] --> [auth/login.php]
[HomeController] --> [posts/index.php]
[PostController] --> [posts/show.php]

@enduml
```

---

## 5. 🗃️ Diagrama Entidad-Relación

```plantuml
@startuml

entity "users" {
    * id : INT [PK]
    --
    * username : VARCHAR(50)
    * password : VARCHAR(255)
    email : VARCHAR(100)
    * created_at : TIMESTAMP
}

entity "posts" {
    * id : INT [PK]
    --
    * title : VARCHAR(150)
    * content : TEXT
    image : VARCHAR(255)
    * user_id : INT [FK]
    * created_at : TIMESTAMP
}

users ||--o{ posts : "crea"

@enduml
```

---

## 6. 📋 Diagrama de Casos de Uso

```plantuml
@startuml

left to right direction

actor Visitante
actor "Usuario Registrado" as User

rectangle "Blog CMS" {
    usecase "Ver posts" as UC1
    usecase "Ver detalle post" as UC2
    usecase "Registrarse" as UC3
    usecase "Iniciar sesion" as UC4
    usecase "Cerrar sesion" as UC5
    usecase "Crear post" as UC6
    usecase "Editar post" as UC7
    usecase "Eliminar post" as UC8
    usecase "Subir imagen" as UC9
}

Visitante --> UC1
Visitante --> UC2
Visitante --> UC3
Visitante --> UC4

User --> UC1
User --> UC2
User --> UC5
User --> UC6
User --> UC7
User --> UC8

UC6 ..> UC9 : extends
UC7 ..> UC9 : extends

@enduml
```

---

## 🔧 Cómo Visualizar

1. Ve a **[plantuml.com/plantuml](https://www.plantuml.com/plantuml/uml/)**
2. Copia el código entre `@startuml` y `@enduml`
3. Se genera la imagen automáticamente
4. Puedes descargarla como PNG o SVG

---

## 📝 Resumen

| Diagrama | Qué muestra |
|----------|-------------|
| **Clases** | Estructura de las clases PHP |
| **Secuencia Login** | Proceso de autenticación |
| **Secuencia Crear Post** | Proceso de crear publicación |
| **Componentes** | Arquitectura MVC del proyecto |
| **Entidad-Relación** | Tablas de la base de datos |
| **Casos de Uso** | Funcionalidades por usuario |

---

*Blog CMS - Diciembre 2025*
