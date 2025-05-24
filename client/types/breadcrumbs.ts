export type Breadcrumbs = Breadcrumb[];

export interface Breadcrumb {
  title: string;
  url?: string;
  icon?: Component;
}
