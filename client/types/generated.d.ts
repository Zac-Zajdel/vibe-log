declare namespace App.Data.Request.StandupGroup {
  export type StandupGroupUpdateData = {
    owner_id: number;
    name: string;
    description?: string | null;
    is_active?: boolean;
    visibility?: App.Enums.StandupGroup.StandupGroupVisibility | null;
    days?: Array<App.Enums.StandupGroup.StandupGroupDay> | null;
  };
}
declare namespace App.Data.Request.User {
  export type UserStoreData = {
    name: string;
    email: string;
    password: string;
  };
  export type UserUpdateData = {
    name?: string;
    email?: string;
    active_workspace_id?: number;
  };
}
declare namespace App.Data.Request.Workspace {
  export type WorkspaceIndexData = {
    search?: string;
    page?: number;
    per_page?: number;
  };
  export type WorkspaceStoreData = {
    owner_id: number;
    name: string;
    description?: string | null;
    logo?: string | null;
  };
  export type WorkspaceUpdateData = {
    owner_id: number;
    name: string;
    description?: string | null;
    logo?: string | null;
    archived_at?: string | null;
  };
}
declare namespace App.Data.Resource.StandupGroup {
  export type StandupGroupResource = {
    id: number;
    workspace_id: number;
    owner_id: number;
    name: string;
    description: string | null;
    visibility: App.Enums.StandupGroup.StandupGroupVisibility;
    is_active: boolean;
    days: Array<App.Enums.StandupGroup.StandupGroupDay> | null;
    created_at: string | null;
    updated_at: string | null;
    owner?: App.Data.Resource.User.UserResource;
    workspace?: App.Data.Resource.Workspace.WorkspaceResource;
  };
}
declare namespace App.Data.Resource.User {
  export type UserResource = {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    remember_token: string | null;
    active_workspace_id: number | null;
    created_at: string | null;
    updated_at: string | null;
    active_workspace?: App.Data.Resource.Workspace.WorkspaceResource;
  };
}
declare namespace App.Data.Resource.Workspace {
  export type WorkspaceResource = {
    id: number;
    owner_id: number;
    name: string;
    description: string | null;
    logo: string | null;
    is_default: boolean;
    archived_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    owner?: App.Data.Resource.User.UserResource;
  };
}
declare namespace App.Data.Transfer.StandupGroup {
  export type StandupGroupData = {
    workspace_id?: number;
    owner_id?: number;
    name?: string;
    description?: string | null;
    visibility?: App.Enums.StandupGroup.StandupGroupVisibility | null;
    is_active?: boolean;
    days?: Array<App.Enums.StandupGroup.StandupGroupDay> | null;
  };
}
declare namespace App.Data.Transfer.User {
  export type UserData = {
    name?: string;
    email?: string;
    password?: string;
    active_workspace_id?: number;
  };
}
declare namespace App.Data.Transfer.Workspace {
  export type WorkspaceData = {
    owner_id?: number;
    name?: string;
    description?: string | null;
    logo?: string | null;
    is_default?: boolean;
    archived_at?: string | null;
  };
}
declare namespace App.Enums.StandupGroup {
  export type StandupGroupDay =
    | 'monday'
    | 'tuesday'
    | 'wednesday'
    | 'thursday'
    | 'friday'
    | 'saturday'
    | 'sunday';
  export type StandupGroupVisibility = 'public' | 'private' | 'invite_only';
}
