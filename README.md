## Installation
```sh
git clone https://github.com/bobochil22/properties-backend.git
cd properties-backend
```

## Build and run
Clone the repository and run ```./run.sh``` with required option to build and run the backend. The backend api will be available at ```http://localhost:8181/api```.

## API
The backend exposes the following API endpoint:
```http://localhost:8181/api/properties```

Supports the following search params:
- ```name```: property name (string)
- ```bedrooms```: number of bedrooms (integer)
- ```bathrooms```: number of bathrooms (integer)
- ```storeys```: number of storeys (integer)
- ```garages```: number of garages (integer)
- ```price_range```: price range (string) - format: ```<min_price>,<max_price>```

## Backend specs
- The laravel version used is 8.54
- The backend is using postgresql-14.7 as database
- The backend is using php-8.2-fpm as php version

## Notes
The given dataset is added to repository in the form of json file ```properties.json```. The file is located at ```backend/storage/app/properties.json```. The file is loaded to database when the seeder is run. The file can be replaced with another file with the same name and format to load different dataset.