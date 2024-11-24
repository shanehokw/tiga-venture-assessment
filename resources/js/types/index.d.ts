export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type Task = {
    name: string;
    description: string;
    due_date: string;
    created_at: string;
    updated_at: string;
};

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
