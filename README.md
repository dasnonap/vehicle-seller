# Vehicle System - Full Stack Application

This repository contains both the frontend and backend code for the **Vehicle System**. The project provides functionality for users to create and view vehicles, and manage user interactions based on roles. It consists of a **React (Vite)** frontend and a **Symfony** backend. The backend is responsible for handling authentication, authorization, user roles, and vehicle management, while the frontend manages user interaction and state using React and MobX.

## Table of Contents
1. [Project Structure](#project-structure)
2. [Functionalities](#functionalities)
3. [Setup Instructions](#setup-instructions)
4. [Backend Setup](#backend-setup)
5. [Frontend Setup](#frontend-setup)
6. [Postman Collection](#postman-collection)

---

## Project Structure

```
root/
│
├── vs-backend/     # Symfony 6 backend code (PHP)
├── vs-frontend/    # React + Vite frontend code (JavaScript)
│
├── README.md       # This file
```

---

## Functionalities

The application includes the following key features:

### 1. **Authentication & Authorization**
   - **User Authentication**: Users can log in with credentials to access different areas of the system.
   - **JWT-based Authorization**: The backend uses JSON Web Tokens (JWT) to manage user sessions and access control.

### 2. **User Roles**
   - **ROLE_CREATOR**: Users with this role can create and manage vehicle entries.
   - **ROLE_VIEWER**: Users with this role can only view all vehicles and interact by "liking" them.
   - Both roles can view vehicles, but only creators can add them to the system.

### 3. **Vehicle Management**
   - **Create, Read, Update, Delete (CRUD)** functionality for vehicles, including various types such as cars, trucks, motorcycles, and trailers.
   - Vehicles can be "liked" by users, and the liked vehicles are stored in the database.

---

## Setup Instructions

This project is divided into two main components: the **backend** and **frontend**. Below are the instructions to set up and run the system locally.

### Prerequisites
Ensure the following tools are installed on your machine:
- **PHP** (>= 8.1) and **Composer** (for the Symfony backend)
- **Node.js** (>= 14.x) and **npm** or **yarn** (for the React frontend)
- **MySQL** or **PostgreSQL** (for the database)

---

## Backend Setup (Symfony)

1. **Navigate to the backend directory**:
   ```bash
   cd vs-backend
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up environment variables**:
   - Create a `.env.local` file based on the `.env` file provided, and configure the database connection:
   ```dotenv
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
   ```

4. **Set up the database**:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Run the Symfony server**:
   ```bash
   symfony server:start
   ```

---

## Frontend Setup (React + Vite)

1. **Navigate to the frontend directory**:
   ```bash
   cd vs-frontend
   ```

2. **Install dependencies**:
   ```bash
   npm install
   ```

3. **Configure the environment**:
   - Create an `.env` file in the `vs-frontend` directory and set the base URL for the backend:
     ```dotenv
     VITE_API_BASE_URL=http://localhost:8000/api
     ```

4. **Run the development server**:
   ```bash
   npm run dev
   ```

5. **Build for production**:
   ```bash
   npm run build
   ```

---

## Postman Collection

To facilitate API testing, a Postman collection is available, which includes all backend routes and requests related to authentication, user management, and vehicle management.

[Postman Collection Link](https://lunar-crescent-300275.postman.co/workspace/My-Workspace~93105f9e-e4cc-40c8-85d7-547242dce824/collection/10981681-f8892beb-4cf6-414f-8731-c4a47cbd0325?action=share&source=copy-link&creator=10981681)

---

If you encounter any issues or need further assistance with the setup, please refer to the official documentation of Symfony, React, or the respective tools, or raise an issue in this repository.
