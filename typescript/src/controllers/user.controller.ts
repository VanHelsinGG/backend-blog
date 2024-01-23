import { Request, Response } from 'express';
import User, { IUser } from '../models/user.model';
import { Model } from '../types/models.type';

export default class UserController {
    static async all(req: Request, res: Response): Promise<void> {
        try {
            const users: Model<IUser>[] = await User.find();
            res.status(200).json({ users });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async create(req: Request, res: Response): Promise<void | Response> {
        try {
            const { name, email } = req.body;

            if (!name || !email) {
                return res.status(400).json({ error: 'Nome e email são obrigatórios.' });
            }

            // TODO: Verificar email e name

            const newUser: Model<IUser> = new User({
                name,
                email,
            });

            const user: Model<IUser> = await newUser.save();

            res.status(201).json({ message: 'Usuário criado com sucesso', user: user });

        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async find(req: Request, res: Response): Promise<void | Response> {
        try {
            const userID = req.params.userID

            if (!userID) {
                return res.status(400).json({ error: 'ID do usuário inválido.' });
            }

            const user: Model<IUser> = await User.findById(userID);

            if (!user) {
                return res.status(404).json({ error: 'Usuário não encontrado.' });
            }

            res.status(200).json({ user: user });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async delete(req: Request, res: Response): Promise<void | Response> {
        try {
            const userID = req.params.userID;

            if (!userID) {
                return res.status(400).json({ error: 'ID do usuário inválido.' });
            }

            const result = await User.deleteOne({ _id: userID });

            if (result.deletedCount === 0) {
                return res.status(404).json({ error: 'Usuário não encontrado.' });
            }

            res.status(200).json({ message: 'Usuário deletado com sucesso!', result });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

    static async update(req: Request, res: Response): Promise<void | Response> {
        try {
            const { name, email } = req.body;
            const userID = req.params.userID;

            if (!userID) {
                return res.status(400).json({ error: 'ID do usuário inválido.' });
            }

            if (!name || !email) {
                return res.status(400).json({ error: 'Nome e email são obrigatórios.' });
            }

            const updatedUser: Model<IUser> = await User.findByIdAndUpdate(
                userID,
                { name, email },
                { new: true }
            );

            if (!updatedUser) {
                return res.status(404).json({ error: 'Usuário não encontrado.' });
            }

            res.status(200).json({ message: 'Usuário atualizado com sucesso!', user: updatedUser });
        } catch (error) {
            res.status(500).json({ error: (error as Error).message });
        }
    }

}