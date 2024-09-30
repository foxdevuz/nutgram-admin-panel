<p style="display: flex; justify-content: center; align-items: center;">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
    <a href="" target="_blank">
        <img src="https://nutgram.dev/img/logo-raw.svg" width="400" alt="Nutgram Logo">
    </a>
</p>

## About Project

This project is an admin panel for controlling Telegram bots using Laravel and Nutgram. It leverages the power of Laravel for backend operations and Nutgram for handling Telegram bot interactions.

### Key Features

- **Admin Panel**: Provides an interface for managing Telegram bots.
- **User Management**: Allows administrators to manage users and their permissions.
- **Statistics**: Displays various statistics related to bot usage.
- **Ads Management**: Enables sending advertisements through the bot.
- **Channel Management**: Facilitates the management of Telegram channels.

### Technologies Used

- **PHP**: The core programming language used for backend development.
- **Laravel**: A PHP framework used for building the web application.
- **Nutgram**: A PHP library for creating Telegram bots.

### Installation

1. **Create as project**:
    ```bash
   composer create-project --stability=dev foxdevuz/ngap    
   cd ./ngap
   ```

2. **Run database migrations**:
    ```bash
    php artisan migrate
    ```

3. **Start the development server on local**:
    ```bash
    php artisan nutgram:run
    ```

### Usage

- **Admin Commands**: Use the `/admin` command to access the admin panel.
- **Statistics**: Use the `stats` command to view bot statistics.
- **Send Ads**: Use the `send_ad` command to send advertisements.
- **Manage Admins**: Use the `manage_admin` command to manage administrators.
- **Manage Channels**: Use the `manage_channels` command to manage Telegram channels.
- **Start Command**: Use the `start` command to initiate the bot.
- **Since it uses localization you will see the commands in `/lang` directory.**
### Environment Variables

- **APP\_NAME**: The name of the application.
- **APP\_ENV**: The application environment (e.g., local, production).
- **APP\_KEY**: The application key.
- **APP\_DEBUG**: Enable or disable debug mode.
- **DB\_CONNECTION**: The database connection type.
- **DB\_HOST**: The database host.
- **DB\_PORT**: The database port.
- **DB\_DATABASE**: The database name.
- **DB\_USERNAME**: The database username.
- **DB\_PASSWORD**: The database password.
- **TELEGRAM\_TOKEN**: The token for the Telegram bot.
- **MAIN\_ADMIN\_ID**: The Telegram ID of the main admin.
- **DEV\_TELEGRAM**: The Telegram username of the developer.

### Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.

### License

This project is licensed under the MIT License. See the `LICENSE` file for more details.
