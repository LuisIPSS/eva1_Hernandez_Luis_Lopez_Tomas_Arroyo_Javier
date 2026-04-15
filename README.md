# Readme.md LaravelOneCommand
1. Configura tu .env.
2. ```docker compose up``` Para crear el container con los servicios requeridos.
3. Espera y verifica que se haya creado el proyecto.
4. ```docker compose exec php php artisan migrate``` Para migrar la base de datos. (Si es necesario)

### ¿Que hace el proyecto?
Para empezar se configura un contenedor los servicios de PHP, MySQL y Nginx con docker-compose.yml. Dentro de PHP se encuentra un Dockerfile que se encarga de instalar las dependencias del sistema a utilizar, extensiones de PHP necesarias y descarga la ultima version de composer para posteriormente establecer el directorio de trabajo y ejecutar el script init.sh que se encarga de crear el proyecto Laravel, dentro de este init.sh, verifica si ya existe el proyecto Laravel comprobando si existe un archivo 'artisan', en caso de que no exista, crea el proyecto. Posteriormente configura el .env del proyecto, tomando los datos del .env de la raiz y reemplaza la configuracion con sed y posteriormente las descomenta, para finalizar establece los permisos necesarios y ejecuta php-fpm.
Para el caso del servicio de MySQL, este se configuro en el puerto default (3306).
Se utiliza Nginx y su respectivo default.conf para renderizar la aplicacion web.

# Readme.md eva1_Hernandez_Luis

Get/metodo check
1.- Ingresamos al contenedor php y ejecutamos ```php artisan make:controller HealthController``` y se crea el controlador en ```app/Controllers/HeHealthController.php```
![alt text](imgs/image.png)

2.- Creamos el metodo check
```php
public function check() {
 return response()->json([
 "status" => "online",
 "version" => "1.0.0",
 "environment" => "docker"
 ], 200);
}
```
3.- En laravel 12 no existe api.php, por lo cual utilizamos ```php artisan install:api``` para crear esta ruta.
Agregamos la ruta ```Route::get('/health', [HealthController::class, 'check']);```, sin antes importar el controlador con ```use App\Http\Controllers\HealthController;```

4.- Verificamos con una peticion GET 
![alt text](imgs/image-1.png)

Migracion de datos
1.- Ingresamos al contenedor php y ejecutamos ```php artisan make:migration create_table_clients```, lo cual crea un archivo en ```database/migrations```
![alt text](imgs/image-2.png)
2.- La tabla es la siguiente
```sql
CREATE TABLE clients (
    client_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    date_of_birth DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
```
Pero necesitamos transformarla a la estructura de laravel, por lo cual en el archivo de migracion quedaria asi:
```php
public function up(): void
{
      Schema::create('clients', function (Blueprint $table) {
        $table->id('client_id');
        $table->string('first_name', 50);
        $table->string('last_name', 50);
        $table->string('email', 100)->unique();
        $table->string('phone_number', 20)->nullable();
        $table->date('date_of_birth')->nullable();
        $table->timestamps();
     });
}
```
Donde factores como el primary key se manejan con $table->id(), los varchar con $table->string() y se especifica la longitud, los unique con ->unique() que no permite duplicados, los nullable con ->nullable() que permite valores nulos y los timestamps con ->timestamps() que crea dos columnas para la fecha y hora de creacion y actualizacion.

3.- Ejecutamos la migracion con ```php artisan migrate```
![alt text](imgs/image-3.png)

4.- Verificamos con dbeaver que la tabla se creo correctamente.
![alt text](imgs/image-4.png)

