/* eslint-disable no-unused-vars */
/* eslint-disable prettier/prettier */

import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, Mail, Phone } from 'lucide-react';

export default function ShowContact(contact) {
    return (
        <>
            <Head
                title={`${contact.contact.firstname} ${contact.contact.lastname}`}
            />

            <div className="py-12">
                <div className="mx-auto mb-8 max-w-7xl px-8">
                    <Button variant="ghost" asChild>
                        <Link href={route('dashboard')}>
                            <ArrowLeft className="mr-2 h-4 w-4" />
                            Retour
                        </Link>
                    </Button>
                </div>

                <Card className="mx-10 max-w-2xl">
                    <CardHeader>
                        <CardTitle className="text-2xl">
                            {contact.contact.image_path && (
                                <img
                                    src={`/storage/${contact.contact.image_path}`}
                                    className="m-10 h-20 w-20 rounded-full"
                                />
                            )}
                            {contact.contact.firstname}{' '}
                            {contact.contact.lastname}
                        </CardTitle>
                        <CardDescription>Details du contact</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <div className="flex items-center space-x-2">
                            <Mail className="h-4 w-4 text-gray-500" />
                            <a
                                href="#"
                                className="text-blue-200 duration-300 hover:underline"
                            >
                                {contact.contact.email}
                            </a>
                        </div>
                        <div className="flex items-center space-x-2">
                            <Phone className="h-4 w-4 text-gray-500" />
                            <a
                                href="#"
                                className="text-blue-200 duration-300 hover:underline"
                            >
                                {contact.contact.phoneNumber}
                            </a>
                        </div>
                        {contact.contact.notes && (
                            <div className="flex items-center space-x-2">
                                <div className="mt-6">
                                    <h3 className="text-600 text-lg"> Notes</h3>
                                    <p className="font-semibold text-gray-500">
                                        {contact.contact.notes}
                                    </p>
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
