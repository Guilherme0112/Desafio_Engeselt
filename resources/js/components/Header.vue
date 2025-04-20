<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Header',
    props: {
        auth: Object
    },
    components: {
        Link
    }
};
</script>

<template>

    <header>
        <nav>

            <ul>

                <li>
                    <Link href="/">Início</Link>
                </li>
                <li>
                    <Link href="/confectionerys">Marketplace</Link>
                </li>

                <template v-if="!auth.user">
                    <li>
                        <Link href="/login">Login</Link>
                    </li>
                    <li>
                        <Link href="/register">Criar Conta</Link>
                    </li>
                </template>

                <template v-else>
                    <li>
                        <Link href="/dashboard">Dashboard</Link>
                    </li>
                    <li>
                        <Link href="/profile">Perfil</Link>
                    </li>
                    <li>
                        <Link href="/logout" method="post" as="button" style="background-color: transparent; border: 0; font-size: 18px; font-weight: 600; cursor: pointer;">Sair</Link>
                    </li>
                </template>

            </ul>

        </nav>

    </header>
</template>
