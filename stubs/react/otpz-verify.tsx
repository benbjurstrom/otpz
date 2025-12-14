import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler, useEffect, useState } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index } from '@/routes/otpz';
import AuthLayout from '@/layouts/auth-layout';

interface LoginForm {
    code: string;
}

interface LoginProps {
    status?: string;
    id: string;
    email: string;
    url: string;
}

export default function Login({ status, id, email, url }: LoginProps) {
    const { data, setData, post, processing, errors, reset } = useForm<LoginForm>({
        code: '',
    });
    const [displayValue, setDisplayValue] = useState('');

    // Format the input value with a dash
    const formatValue = (value: string): string => {
        // Remove any non-alphanumeric characters
        const alphanumeric = value.replace(/[^a-zA-Z0-9]/g, '');

        // Format with dash if length > 5
        if (alphanumeric.length <= 5) {
            return alphanumeric;
        } else {
            const firstPart = alphanumeric.substring(0, 5);
            const secondPart = alphanumeric.substring(5, 10);
            return `${firstPart}-${secondPart}`;
        }
    };

    // Handler for input changes
    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const inputValue = e.target.value;

        // Process the input value
        const formattedValue = formatValue(inputValue);
        setDisplayValue(formattedValue);

        // Store the raw value (without dash) in form data
        setData('code', formattedValue.replace('-', ''));
    };

    // Update display value when data.code changes (for reset functionality)
    useEffect(() => {
        if (data.code === '') {
            setDisplayValue('');
        }
    }, [data.code]);

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(url, {
            onFinish: () => {
                reset('code');
                setDisplayValue('');
            },
        });
    };

    return (
        <AuthLayout title="Use your code to login" description={`Enter the login code that was sent to ${email} Note that the code is case insensitive.`}>
            <Head title="Log in" />

            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="code">Login Code</Label>
                        <Input
                            className="text-center uppercase placeholder:lowercase"
                            id="code"
                            type="text"
                            required
                            autoFocus
                            tabIndex={1}
                            maxLength={11} // 10 chars + 1 dash
                            autoComplete="off"
                            value={displayValue}
                            onChange={handleInputChange}
                            placeholder="xxxxx-xxxxx"
                        />
                        <InputError message={errors.code} />
                    </div>

                    <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Submit Code
                    </Button>
                </div>

                <div className="text-muted-foreground text-center text-sm">
                    Didn't receive it?{' '}
                    <TextLink href={index.url()} tabIndex={5}>
                        Request a new code
                    </TextLink>
                </div>
            </form>

            {status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}
        </AuthLayout>
    );
}
