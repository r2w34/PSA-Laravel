# Dokploy Deployment Guide for Parmanand Sports Academy

This guide provides instructions for deploying the Parmanand Sports Academy application using Dokploy.

## Dokploy Configuration

When setting up your application in Dokploy, use the following configuration:

### Basic Settings

- **Github Account**: Your GitHub account
- **Repository**: r2w34/PSA-NASHIK
- **Branch**: main (or your preferred branch)
- **Build Path**: / (root directory)
- **Trigger Type**: On Push
- **Watch Paths**: Leave empty to watch all files, or specify paths like `server/**`, `client/**`
- **Enable Submodules**: No (unless you have submodules)

### Build Configuration

- **Build Type**: Dockerfile
- **Docker File**: Dockerfile
- **Docker Context Path**: . (root directory)
- **Docker Build Stage**: Leave empty (uses the last stage by default)

## Environment Variables

Make sure to set the following environment variables in Dokploy:

```
NODE_ENV=production
PORT=5000
DATABASE_URL=your_database_connection_string
SESSION_SECRET=your_session_secret
GEMINI_API_KEY=your_gemini_api_key (if using Gemini AI)
STRIPE_SECRET_KEY=your_stripe_secret_key (if using Stripe)
VITE_STRIPE_PUBLIC_KEY=your_stripe_public_key (if using Stripe)
```

## Deployment Process

1. Push your changes to the configured GitHub repository and branch
2. Dokploy will automatically detect changes and start the build process
3. The Dockerfile will be used to build a container image
4. Dokploy will deploy the container and make it available at the assigned URL

## Monitoring and Logs

- Use the Dokploy dashboard to monitor your application's status
- Check the logs for any issues during deployment or runtime
- The application exposes a health check endpoint at `/api/health`

## Troubleshooting

If you encounter issues during deployment:

1. Check the Dokploy build logs for errors
2. Verify that all required environment variables are set
3. Ensure the database connection is properly configured
4. Check the application logs for runtime errors

## Manual Deployment

If you need to deploy manually:

1. Clone the repository
2. Build the Docker image: `docker build -t psa-nashik .`
3. Run the container: `docker run -p 5000:5000 --env-file .env.production psa-nashik`

## Support

For additional support, refer to the Dokploy documentation or contact your system administrator.