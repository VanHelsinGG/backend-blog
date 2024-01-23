import express from 'express';
import mongoose from 'mongoose';
import bodyParser from 'body-parser';
import userRoutes from './routes/user.routes';
import postRoutes from './routes/post.routes';

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());

app.use('/api', userRoutes);
app.use('/api', postRoutes);

mongoose.connect('mongodb://localhost:27017/db_blogproject');

app.listen(PORT, () => {
  console.log(`API is running at http://localhost:${PORT}`);
});
