# Project Setup Guide

## Prerequisites

Make sure you have the following installed on your system:

- **Composer**
- **PHP 8.4**
- **Node.js 22**
- **npm 10.9**
- **yarn 1.22**

> Other versions might work, but they have not been tested.

---

To set up the project, start by running the installation script:

```sh
./install.sh
```

This script will:

- Create `.env` from `.env.example` (if it doesn’t exist) in `apps/api`
- Install PHP dependencies with Composer
- Generate a JWT secret
- Install Node dependencies in `apps/chat` and `apps/web-app`
- Create `local.config.json` in `apps/chat` with the generated JWT secret

> If you don't want to use prepared Docker databases, feel free to update the config with your own database server.
---


## Running the Services

You can start the backend, chat server, and web app using the `Makefile` included in the project root.

### Available Commands

- `make api` — Run the Laravel API server
- `make databases` - Build and run databases
- `make chat` — Run the Node chat server
- `make web` — Run the web app

> For more details, see the [`Makefile`](./Makefile).
---

## Known Issues

- **JWT Secret Security:** Currently, the JWT secret is stored in plain text in `local.config.json`. A more secure approach would be to avoid sharing the secret and use refresh tokens instead of storing access tokens in cookies.
- **Token Expiry:** JWT tokens or cookies can expire on the frontend. When this happens, you need to manually log in again to get a fresh access token.
- **Code Quality Tools:** Static analysis and code style sniffers are not yet set up in the project.
