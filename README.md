## Setup & run
Clone the project.

Build images and start containers:
```bash
docker-compose up -d
```

Install all dependencies
```bash
docker exec app composer install
```

Run the script
```bash
docker exec app php index.php
```

log.txt file location '/src/app/log.txt'