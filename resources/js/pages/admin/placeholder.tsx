import { Head } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

export default function AdminPlaceholder({ title }: { title: string }) {
    return (
        <>
            <Head title={title} />
            <div className="flex flex-col gap-6 p-6">
                <h1 className="text-2xl font-semibold">{title}</h1>
                <Card>
                    <CardHeader>
                        <CardTitle>Segera hadir</CardTitle>
                    </CardHeader>
                    <CardContent>Fitur ini akan diimplementasikan pada fase berikutnya.</CardContent>
                </Card>
            </div>
        </>
    );
}