declare namespace App.Data.Request.User {
  export type UserStoreData = {
    name: string;
    email: string;
    password: string;
  };
}
declare namespace App.Data.Request.Workspace {
  export type WorkspaceStoreData = {
    user_id: number;
    name: string;
    description: string | null;
    logo: string | null;
  };
}
declare namespace App.Data.Resource.User {
  export type UserResource = {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    remember_token: string | null;
    created_at: string;
    updated_at: string;
  };
}
declare namespace App.Data.Resource.Workspace {
  export type WorkspaceResource = {
    id: number;
    user_id: number;
    name: string | null;
    description: string | null;
    logo: string | null;
    archived_at: string | null;
    created_at: string;
    updated_at: string;
    user?: App.Data.Resource.User.UserResource;
  };
}
declare namespace App.Data.Transfer.User {
  export type UserData = {
    name: string | null;
    email: string | null;
    password: string | null;
  };
}
declare namespace App.Data.Transfer.Workspace {
  export type WorkspaceData = {
    user_id: number | null;
    name: string | null;
    description: string | null;
    logo: string | null;
    archived_at: string | null;
  };
}
