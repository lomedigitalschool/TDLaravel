import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

import { Schema } from '@/schema/Schema';
import { router, useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import * as yup from 'yup';

export default function ContactModal({
    showModal,
    modalTypes,
    onClose,
    contact,
}) {
    const { data, setData, post, put, errors, processing, reset } = useForm({
        firstname: contact?.firstname || '',
        lastname: contact?.lastname || '',
        email: contact?.email || '',
        phoneNumber: contact?.phoneNumber || '',
        notes: contact?.notes || '',
        image_path: contact?.image_path || '',
    });

    useEffect(() => {
        if (contact && modalTypes === 'edit') {
            setData({
                firstname: contact.firstname,
                lastname: contact.lastname,
                email: contact.email,
                phoneNumber: contact.phoneNumber,
                notes: contact.notes,
                image_path: contact.image_path,
            });
        } else if (contact && modalTypes === 'create') {
            reset();
        }
    }, [contact, showModal, modalTypes]);

    const validatedForm = async () => {
        try {
            await Schema.validate(data, { abortEarly: false });
            return { isValid: true, errors: {} };
        } catch (error) {
            if (error instanceof yup.ValidationError) {
                const validationErrors = {};
                error.inner.forEach((err) => {
                    if (err.path) {
                        validationErrors[err.path] = err.message;
                    }
                });
                return { isValid: false, errors: validationErrors };
            }

            return {
                isValid: false,
                errors: { general: 'Une erreur inattendue est survenue.' },
            };
        }
    };

    const onSubmit = async (e) => {
        e.preventDefault();
        const isValid = await validatedForm();

        if (!isValid) {
            return;
        }

        if (modalTypes === 'create') {
            post(route('contacts.store'), {
                preserveScroll: true,

                onSuccess: () => {
                    handleClose();
                    router.reload();
                },
            });
        } else {
            put(route('contacts.update', contact?.id), {
                preserveScroll: true,

                onSuccess: () => {
                    handleClose();
                    router.reload();
                },
                onError: (errors) => {
                    console.error(errors);
                },
            });
        }
    };

    const handleClose = () => {
        if (modalTypes === 'create') {
            reset();
        }

        onClose();
    };

    return (
        <Dialog open={showModal} onOpenChange={handleClose}>
            <DialogContent className="max-w-[435px]">
                <DialogHeader>
                    <DialogTitle>
                        {modalTypes === 'create'
                            ? 'Nouveau contact'
                            : 'Modifier contact'}
                    </DialogTitle>
                </DialogHeader>
                <form onSubmit={onSubmit} className="space-y-4">
                    <div className="grid-cols2 grid gap-4">
                        <div className="space-y-4">
                            <Label htmlFor="firstname">Prenom</Label>
                            <Input
                                id="firstname"
                                value={data.firstname}
                                onChange={(e) =>
                                    setData(
                                        'firstname',
                                        e.target.value
                                            ? e.target.value
                                            : data.firstname,
                                    )
                                }
                                className={errors.firstname && 'border-red-500'}
                            />
                            {errors.firstname && (
                                <p className="text-sm text-red-500">
                                    {errors.firstname}
                                </p>
                            )}
                        </div>
                        <div className="space-y-4">
                            <Label htmlFor="lastname">Nom</Label>
                            <Input
                                id="lastname"
                                value={data.lastname}
                                onChange={(e) =>
                                    setData('lastname', e.target.value)
                                }
                                className={errors.lastname && 'border-red-500'}
                            />
                            {errors.lastname && (
                                <p className="text-sm text-red-500">
                                    {errors.lastname}
                                </p>
                            )}
                        </div>
                        <div className="space-y-4">
                            <Label htmlFor="email">email</Label>
                            <Input
                                id="email"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                className={errors.email && 'border-red-500'}
                            />
                            {errors.email && (
                                <p className="text-sm text-red-500">
                                    {errors.email}
                                </p>
                            )}
                        </div>
                        <div className="space-y-4">
                            <Label htmlFor="phoneNumber">
                                Numero de telephone
                            </Label>
                            <Input
                                id="phoneNumber"
                                value={data.phoneNumber}
                                onChange={(e) =>
                                    setData('phoneNumber', e.target.value)
                                }
                                className={
                                    errors.phoneNumber && 'border-red-500'
                                }
                            />
                            {errors.phoneNumber && (
                                <p className="text-sm text-red-500">
                                    {errors.phoneNumber}
                                </p>
                            )}
                        </div>
                        <div className="space-y-4">
                            <Label htmlFor="notes">notes</Label>
                            <Textarea
                                id="notes"
                                value={data.notes}
                                onChange={(e) =>
                                    setData('notes', e.target.value)
                                }
                                className={
                                    errors.notes &&
                                    'border-red-500' + 'resize-none'
                                }
                            />
                            {errors.notes && (
                                <p className="text-sm text-red-500">
                                    {errros.notes}
                                </p>
                            )}
                        </div>
                        <div className="space-y-4">
                            <Label htmlFor="image_path">image</Label>
                            <Input
                                id="image_path"
                                type="file"
                                onChange={(e) =>
                                    setData('image_path', e.target.files[0])
                                }
                                className="border-gray-500"
                                name="image_path"
                            />
                            {errors.image_path && (
                                <p className="text-sm text-red-500">
                                    {errors.image_path}
                                </p>
                            )}
                        </div>
                    </div>
                    <div className="flex justify-end space-x-2">
                        <Button
                            variant={'outline'}
                            type="button"
                            onClick={handleClose}
                        >
                            Annuler
                        </Button>
                        <Button disabled={processing} type="submit">
                            {modalTypes === 'create' ? 'Créer' : 'Modifier'}
                        </Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>
    );
}
