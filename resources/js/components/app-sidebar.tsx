import { Link } from '@inertiajs/react';
import {
    BookOpen,
    FolderGit2,
    LayoutGrid,
    Package,
    Tags,
    Award,
    ShoppingCart,
    FileText,
    Receipt,
    Upload,
    Star,
    Newspaper,
    HelpCircle,
    File,
    Calculator,
    Settings,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import admin from '@/routes/admin';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    { title: 'Dashboard', href: admin.dashboard(), icon: LayoutGrid },
    { title: 'Produk', href: admin.products.index(), icon: Package },
    { title: 'Kategori', href: admin.categories.index(), icon: Tags },
    { title: 'Brand', href: admin.brands.index(), icon: Award },
    { title: 'Pesanan', href: admin.orders.index(), icon: ShoppingCart },
    { title: 'RFQ', href: admin.rfqs.index(), icon: FileText },
    { title: 'Quotation', href: admin.quotations.index(), icon: Receipt },
    { title: 'UPO', href: admin.upo.index(), icon: Upload },
    { title: 'Reviews', href: admin.reviews.index(), icon: Star },
    { title: 'Blog', href: admin.blog.index(), icon: Newspaper },
    { title: 'FAQ', href: admin.faq.index(), icon: HelpCircle },
    { title: 'Halaman', href: admin.pages.index(), icon: File },
    { title: 'Simulasi', href: admin.simulation.index(), icon: Calculator },
    { title: 'Settings', href: admin.settings.index(), icon: Settings },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={admin.dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
