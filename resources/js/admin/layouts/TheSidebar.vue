<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <router-link to="/admin" class="nav-link">
                    <i class="menu-icon mdi mdi-grid-large"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    data-bs-toggle="collapse"
                    href="#shopping"
                    aria-expanded="false"
                    aria-controls="form-elements"
                >
                    <i class="menu-icon mdi mdi-cart"></i>
                    <span class="menu-title">Shopping</span>
                    <i class="mdi mdi-arrow-right-thin ms-auto"></i>
                </a>
                <div class="collapse" id="shopping">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/products"
                                href="pages/forms/basic_elements.html"
                            >
                                Products
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/brands"
                                href="pages/forms/basic_elements.html"
                            >
                                Brands
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/categories"
                                href="pages/forms/basic_elements.html"
                            >
                                Categories
                            </router-link>
                        </li>


                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-bs-toggle="collapse"
                    href="#users"
                    aria-expanded="false"
                    aria-controls="form-elements"
                >
                    <i class="menu-icon mdi mdi-account"></i>
                    <span class="menu-title">Users</span>
                    <i class="mdi mdi-arrow-right-thin ms-auto"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <router-link
                                class="nav-link"
                                to="/user"
                                href="pages/forms/basic_elements.html"
                            >
                                Users
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>


    </nav>
</template>

<script>


export default {
    data() {
        return {
            subMenuName: "",
            activeSubMenu: ""
        }
    },
    methods: {
        toggleSubMenu(subMenuName) {
            if (this.activeSubMenu === subMenuName) {
                this.activeSubMenu = '';
            } else {
                this.activeSubMenu = subMenuName;
            }
        }
    }
}
</script>

