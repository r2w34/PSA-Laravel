import express from 'express';

const router = express.Router();

// Health check endpoint
router.get('/health', (req, res) => {
  res.json({
    status: 'ok',
    message: 'Parmanand Sports Academy API is running',
    environment: process.env.NODE_ENV,
    timestamp: new Date().toISOString(),
    deployment: process.env.DOKPLOY_DEPLOYMENT_ID || 'local'
  });
});

export default router;