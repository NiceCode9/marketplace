import { Head } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

type Stats = {
    products: number;
    orders: number;
    rfqs: number;
};

export default function AdminDashboard({ stats }: { stats: Stats }) {
    return (
        <>
            <Head title="Admin Dashboard" />
            <div className="flex flex-col gap-6 p-6">
                <h1 className="text-2xl font-semibold">Dashboard</h1>
                <div className="grid gap-4 md:grid-cols-3">
                    <Card>
                        <CardHeader>
                            <CardTitle>Total Produk</CardTitle>
                        </CardHeader>
                        <CardContent className="text-3xl font-bold">{stats.products}</CardContent>
                    </Card>
                    <Card>
                        <CardHeader>
                            <CardTitle>Pesanan</CardTitle>
                        </CardHeader>
                        <CardContent className="text-3xl font-bold">{stats.orders}</CardContent>
                    </Card>
                    <Card>
                        <CardHeader>
                            <CardTitle>RFQ Baru</CardTitle>
                        </CardHeader>
                        <CardContent className="text-3xl font-bold">{stats.rfqs}</CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}