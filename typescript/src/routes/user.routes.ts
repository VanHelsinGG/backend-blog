import { Router } from 'express';
import UserController from "../controllers/user.controller"

const router: Router = Router();

router.post('/users', UserController.create);
router.get('/users', UserController.all);
router.get('/users/:userID', UserController.find);
router.delete('/users/:userID', UserController.delete);
router.patch('/users/:userID', UserController.update);

export default router;