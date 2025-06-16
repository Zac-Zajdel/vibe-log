import { Box, CircleUser, Home, Settings } from 'lucide-vue-next';

export type SidebarItems = SidebarItem[];

interface SubItems {
  title: string;
  url: string;
}

export interface SidebarItem {
  title: string;
  url?: string;
  icon: Component;
  subItems?: SubItems[];
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
    title: 'Workspace',
    icon: Box,
    subItems: [
      {
        title: 'General',
        url: '/workspace/general',
      },
      {
        title: 'Members',
        url: '/workspace/members',
      },
      {
        title: 'Integrations',
        url: '/workspace/integrations',
      },
      {
        title: 'Plans',
        url: '/workspace/plans',
      },
    ],
  },
  {
    title: 'Settings',
    url: '/settings',
    icon: Settings,
  },
];
