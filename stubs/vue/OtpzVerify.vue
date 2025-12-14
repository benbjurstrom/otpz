<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { watch } from 'vue';
import { index } from '@/routes/otpz';

defineProps<{
    status?: string;
    email: string;
    url: string;
}>();

const page = usePage();
const email = page.props.email;
const url = page.props.url;

const form = useForm({
    code: '',
});


watch(
    () => form.code,
    (newVal) => {
        // Remove any non-alphanumeric characters
        let cleaned = newVal.replace(/[^a-zA-Z0-9]/g, '');

        // Enforce uppercase
        cleaned = cleaned.toUpperCase();

        // Limit to 10 alphanumeric characters
        cleaned = cleaned.slice(0, 10);

        // Insert dash after 5 characters (if there are more than 5)
        if (cleaned.length > 5) {
            cleaned = cleaned.slice(0, 5) + '-' + cleaned.slice(5);
        }

        // Update form.code only if it differs from what the user typed
        if (cleaned !== newVal) {
            form.code = cleaned;
        }
    }
);

const submit = () => {
    form.post(url);
};
</script>

<template>
    <AuthBase
        title="Use your code to login"
        :description="`Enter the login code that was sent to ${email} Note that the code is case insensitive.`"
    >
        <Head title="Enter Code" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="code">Login Code</Label>
                    <Input
                        id="code"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        :maxlength="11"
                        autocomplete="off"
                        v-model="form.code"
                        placeholder="xxxxx-xxxxx"
                        class="text-center uppercase placeholder:lowercase"
                    />
                    <InputError :message="form.errors.code" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Submit Code
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Didn't receive it?
                <TextLink :href="index.url()" :tabindex="5">Request a new code</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
