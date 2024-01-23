import { Request, Response } from 'express';
import Post, { IPost } from '../models/post.model';
import User, { IUser } from '../models/user.model';
import { Model } from '../types/models.type';

export default class PostController{
    static async all(req: Request, res: Response): Promise<void>{
        try {
            const posts: Model<IPost>[] = await Post.find();
            res.status(200).json({ posts });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async create(req: Request, res: Response): Promise<void | Response>{
        try {
            const {creator, content} = req.body;

            if(!creator || !content){
                return res.status(400).json({ error:"Criador e conteúdo são obrigatórios!" });
            }

            const user: Model<IUser> = await User.findById(creator);

            if(!user){
                return res.status(404).json({ error:"Usuario não encontrado!" });
            }

            const newPost: Model<IPost> = new Post({
                creator, 
                content,
            });

            const post: Model<IPost> = await newPost.save();

            res.status(201).json({ message:"Publicação criada com sucesso!", post });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async find(req: Request, res: Response): Promise<void | Response> {
        try {
            const postID = req.params.postID

            if (!postID) {
                return res.status(400).json({ error: 'ID do Post inválido.' });
            }

            const post: Model<IPost> = await Post.findById(postID);

            if (!post) {
                return res.status(404).json({ error: 'Post não encontrado.' });
            }

            res.status(200).json({ post: post });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async delete(req: Request, res: Response): Promise<void | Response> {
        try {
            const postID = req.params.postID;

            if (!postID) {
                return res.status(400).json({ error: 'ID do Post inválido.' });
            }

            const result = await Post.deleteOne({ _id: postID });

            if (result.deletedCount === 0) {
                return res.status(404).json({ error: 'Post não encontrado.' });
            }

            res.status(200).json({ message: 'Post deletado com sucesso!', result });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async update(req: Request, res: Response): Promise<void | Response> {
        try {
            const { creator, content } = req.body;
            const postID = req.params.postID;

            if (!postID) {
                return res.status(400).json({ error: 'ID do post inválido.' });
            }

            if (!creator || !content) {
                return res.status(400).json({ error: 'Usuario e Conteúdo são obrigatórios.' });
            }

            const user = User.findById(creator);

            if(!user){
                return res.status(404).json({ error: 'Usuario não encontrado.' });
            }

            const updatedPost: Model<IPost> = await Post.findByIdAndUpdate(
                postID,
                { creator, content },
                { new: true }
            );

            if (!updatedPost) {
                return res.status(404).json({ error: 'Post não encontrado.' });
            }

            res.status(200).json({ message: 'Post atualizado com sucesso!', post: updatedPost });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }
}