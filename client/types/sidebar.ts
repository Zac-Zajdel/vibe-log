import { BookText, Settings, User, UserRoundPen } from 'lucide-vue-next';

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
    title: 'Standup',
    url: '/standup',
    icon: UserRoundPen,
  },
  {
    title: 'Templates',
    url: '/templates',
    icon: BookText,
  },
  {
    title: 'Members',
    url: '/workspace/members',
    icon: User,
  },
  {
    title: 'Settings',
    url: '/workspace/general',
    icon: Settings,
  },
];
