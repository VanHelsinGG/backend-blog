import { Router } from 'express';
import PostController from "../controllers/post.controller"

const router: Router = Router();

router.post('/posts', PostController.create);
router.get('/posts', PostController.all);
router.get('/posts/:postID', PostController.find);
router.delete('/posts/:postID', PostController.delete);
router.patch('/posts/:postID', PostController.update);

export default router;