import mongoose, { Schema, Document } from "mongoose";

export interface IPost extends Document {
    creator: string;
    content: string;
    created_at: Date;
    Updated_at: Date;
}

const postSchema: Schema = new Schema({
    creator: {type:String, required: true},
    content: {type:String, required: true},
    created_at: {type: Date, default: Date.now},
    updated_at: {type: Date, default: Date.now},
});

export default mongoose.model<IPost>('Post', postSchema);