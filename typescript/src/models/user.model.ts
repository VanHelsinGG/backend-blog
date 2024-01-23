import mongoose, { Schema, Document } from "mongoose";

export interface IUser extends Document {
    name: string;
    email: string;
    created_at: Date;
    updated_at: Date;
}

const userSchema: Schema = new Schema({
    name: { type: String, required: true },
    email: { type: String, required: true, unique: true },
    created_at: {type: Date, default: Date.now},
    updated_at: {type: Date, default: Date.now},
});

export default mongoose.model<IUser>('User', userSchema);