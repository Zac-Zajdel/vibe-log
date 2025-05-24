import { CircleUser, Home, Settings } from 'lucide-vue-next';

export type SidebarItems = SidebarItem[];

export interface SidebarItem {
  title: string;
  url: string;
  icon: Component;
}

export const sidebarOptions: SidebarItems = [
  {
    title: 'Home',
    url: '/home',
    icon: Home,
  },
  {
    title: 'Standup',
    url: '/standup',
    icon: CircleUser,
  },
  {
    title: 'Settings',
    url: '/settings',
    icon: Settings,
  },
];
