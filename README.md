# SCS Test Task

## Setup Instructions

1. **Copy the example files and adjust if necessary:**

   ```
   cp .env.example .env
   cp compose.override.example.yaml compose.override.yaml
   ```

2. **Run Docker containers:**

   Pull the required images and start the application:
   ```
   docker compose pull
   docker compose up -d
   ```
3. **Access the API:**

   The API will be available at:
   ```
   http://localhost:<port>/
   ```
   An example request:
   ```
   curl -X POST http://localhost:<port>/ \
   -H "Content-Type: application/json" \
   -d '{
   "source": "my_source",
   "payload": {
   "email": "user@example.com",
   "name": "John Doe"
   }
   }'
   ```
   Replace <port> with the port number specified in compose.override.yaml
4. **Stop the application:**

   To stop and remove containers:
   ```
   docker compose down
   ```
