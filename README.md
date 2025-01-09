# Car Rental System

This project is a car rental system built with Laravel. It allows users to book cars for specific dates, ensuring that no car is booked twice or for overlapping periods. The system also includes features for applying discounts for long-term rentals and managing payment statuses.

## Features

- **Car Listing**: Display a list of available cars with details like id, name, type, price_per_day, availability_status, and an optional image.
- **Search and Filter**:
    - Search cars by name.
    - Filter cars by type, price range, and availability status.
- **Order Creation**:
    - Users can select a car, specify the rental start and end dates.
    - The system calculates the total rental price based on the selected dates.
    - Save the order details, including order_id, user_id, car_id, start_date, end_date, total_price, and payment_status (paid, unpaid).
- **Cash Payment**: Update the payment_status to paid upon successful cash payment.
- **Validation**: Validate user input (e.g., start date should be before the end date).
- **Database Seeding**: Populate the database with at least 10 cars and 5 users (the admin credentials are "admin@email.com" "password").

## Authentication
- authentication is done using Laravel's Fortify and Sanctum packages. The system includes two roles: user and admin. The admin can add new cars and mark cars as unavailable for maintenance.
- it's a simple authentication system that includes login, registration, and logout only.
- cookie based authentication is used for the web routes and token based authentication is used for the API routes.
## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/YousefHSS/AbudiyabTask.git
    cd AbudiyabTask
    ```

2. Install dependencies:
    ```sh
    composer install
    npm install
    ```

3. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```sh
    cp .env.example .env
    ```

4. Generate the application key:
    ```sh
    php artisan key:generate
    ```

5. Run the database migrations:
    ```sh
    php artisan migrate
    ```

6. Seed the database:
    ```sh
    php artisan db:seed
    ```

7. Start the development server:
    ```sh
    php artisan serve
    ```

## API Endpoints

### Car Listing

- **GET /cars**: List all available cars with search and filter options.

### Order Creation

- **POST /orders**: Create a new order.
    - Parameters:
        - `user_id`: The ID of the user making the booking
        - `car_id`: The ID of the car to be booked
        - `start_date`: The start date of the booking (format: `YYYY-MM-DD`)
        - `end_date`: The end date of the booking (format: `YYYY-MM-DD`)

### Cash Payment

- **PATCH /orders/{order_id}/pay**: Mark an order as paid via cash.

### User Orders

- **GET /orders**: List all orders for a user.

### Admin Features

- **POST /admin/cars**: Add a new car (admin only).
- **PATCH /admin/cars/{car_id}/maintenance**: Mark a car as unavailable for maintenance (admin only).

### Car Images

- **GET /storage/images/{filename}**: Retrieve car images.
## Database Tables

### Users

- `id`, `name`, `email`, `password`,  `role` (e.g., user, admin).

### Cars

- `id`, `name`, `type`, `price_per_day`, `availability_status`,`image`.

### Orders

- `id`, `user_id`, `car_id`, `start_date`, `end_date`, `total_price`, `payment_status`.


## API Collections (Postman)

You can download the Postman collection used to test the APIs from the following link:

[Download Postman Collections](Collections)
## License

This project is licensed under the MIT License.
