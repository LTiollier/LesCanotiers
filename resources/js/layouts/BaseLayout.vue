<template>
    <v-app id="app">
        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            app>
            <v-list dense>
                <v-list-item-group v-model="$page.activeNavigation">
                    <template v-for="item in $page.navigation">
                        <v-list-group
                            v-if="item.children"
                            :key="item.text"
                            v-model="item.model"
                            :prepend-icon="item.model ? item.icon : item['icon-alt']"
                            append-icon="">
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ item.text }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </template>
                            <v-list-item
                                v-for="(child, i) in item.children"
                                :key="i"
                                link>
                                <v-list-item-action v-if="child.icon">
                                    <v-icon>{{ child.icon }}</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ child.text }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                        <v-list-item
                            v-else
                            :key="item.text"
                            link
                            @click="visit(item.href)">
                            <v-list-item-action>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="primary"
            dark>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title
                style="width: 300px"
                class="ml-0 pl-4">
                <span class="hidden-sm-and-down">Les Cannotiers</span>
            </v-toolbar-title>
            <v-spacer />
            <div class="text-center">
                <v-menu offset-y>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            fab
                            small
                            color="white"
                            elevation="0"
                            v-on="on">
                            <v-avatar
                                size="32px"
                                item>
                                <v-img
                                    src="/images/logo_icon.svg"
                                    alt="Pollen BO" />
                            </v-avatar>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>
                                <inertia-link :href="route('users.edit', {'user': 'me'})">
                                    Profile
                                </inertia-link>
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>
                                <a :href="route('logout')">Déconnexion</a>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </v-app-bar>
        <v-main>
            <offline-dialog />
            <slot />
        </v-main>
        <snackbar />
    </v-app>
</template>

<script>
import Snackbar from "../components/Snackbar";
import OfflineDialog from "../components/dialogs/OfflineDialog";

export default {
    name: "BaseLayout",
    components: {
        OfflineDialog,
        Snackbar
    },
    data: () => ({
        drawer: null,
    }),
    methods: {
        visit(link) {
            this.$inertia.visit(link);
        }
    }
}
</script>
