import { Request, Response, NextFunction } from 'express';

// Simple authentication middleware for development
// In production, this should be replaced with proper JWT or session-based authentication
export const requireAuth = (req: Request, res: Response, next: NextFunction) => {
  // For development, we'll simulate an authenticated user
  // In production, this should verify JWT tokens or session cookies
  
  // Check for authorization header or session
  const authHeader = req.headers.authorization;
  const sessionUser = (req as any).session?.user;
  
  if (authHeader && authHeader.startsWith('Bearer ')) {
    // JWT token authentication (for production)
    const token = authHeader.substring(7);
    // TODO: Verify JWT token and extract user info
    // For now, simulate a user
    (req as any).user = { id: 1, email: 'admin@psa.com', role: 'admin' };
    return next();
  } else if (sessionUser) {
    // Session-based authentication
    (req as any).user = sessionUser;
    return next();
  } else {
    // For development, allow all requests with a default user
    // In production, this should return 401 Unauthorized
    if (process.env.NODE_ENV === 'development') {
      (req as any).user = { id: 1, email: 'admin@psa.com', role: 'admin' };
      return next();
    } else {
      return res.status(401).json({ error: 'Authentication required' });
    }
  }
};

// Optional: More specific role-based middleware
export const requireRole = (role: string) => {
  return (req: Request, res: Response, next: NextFunction) => {
    const user = (req as any).user;
    if (!user) {
      return res.status(401).json({ error: 'Authentication required' });
    }
    if (user.role !== role && user.role !== 'admin') {
      return res.status(403).json({ error: 'Insufficient permissions' });
    }
    next();
  };
};

// Optional: Admin-only middleware
export const requireAdmin = requireRole('admin');