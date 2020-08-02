function initialCount(obj) {
    var count0 = 0;
    Object.entries(obj).forEach(([key, value]) => {
        if (Array.isArray(value)) {
            value.forEach(j => {
                count0++;
            });
        } else {
            count0++;
        }
    });
    return count0;
}
function sizeObj(obj) {
    var count0 = 0;
    var key0;
    for (key0 in obj) {
        if (obj.hasOwnProperty(key0)) {
            count0++;
        }
    }
    return count0;
}
function total(cart) {
    var total_price = 0;
    Object.entries(cart).forEach(([key, value]) => {
        if (Array.isArray(value)) {
            value.forEach(item => {
                total_price += ((item.price - item.discount) * item.quantity);
            });
        } else {
            total_price += ((cart[key].price - cart[key].discount) * cart[key].quantity);
        }
    });
    /* for (const key in cart) {
        total_price += ((cart[key].price - cart[key].discount) * cart[key].quantity);
    } */
    return total_price;
}

export default {
	state: {
        drawer: null,
        cart: (localStorage.getItem('cart')) ? localStorage.getItem('cart') : '{}',
        count: (localStorage.getItem('cart')) ? initialCount(JSON.parse(localStorage.getItem('cart'))) : 0,
        total: (localStorage.getItem('cart')) ? total(JSON.parse(localStorage.getItem('cart'))) : 0,
	},
    mutations: {
        openDrawer(state, open) {
            state.drawer = open;
        },
        changeCart (state, item) {
            state.cart = item
        },
        changeCount (state, i) {
            state.count = i
        },
        changeTotal(state, n) {
            state.total = n
        }
    },
	actions: {
        openNavigationDrawer({commit}, open) {
            commit('openDrawer', open);
        },
        addItem({commit}, opt) {
            axios.get(`${location.protocol}//${window.location.hostname}/add/${opt.slug}`)
            .then((response) => {
                // console.log(response);
                if (opt.attribute !== null) {
                    response.data.attr = opt.attribute;
                }
                if (localStorage.getItem('cart')) {
                    const tmp = JSON.parse(localStorage.getItem('cart'));
                    if (opt.attribute !== null) {
                        if ((opt.slug in tmp)) {
                            // tmp[opt.slug].push(response.data);
                            var add = true;
                            tmp[opt.slug].forEach(element => {
                                var con = 0;
                                Object.entries(opt.attribute).forEach(([key, value]) => {
                                    if (element.attr[key] === value) con++;
                                });
                                if (con === sizeObj(element.attr)) add = false;
                            });
                            // console.log(add);
                            if (add) tmp[opt.slug].push(response.data);
                        } else {
                            // const tmparray = [response.data];
                            tmp[opt.slug] = [response.data];
                        }
                    } else {
                        if (!(opt.slug in tmp)) tmp[opt.slug] = response.data;
                    }
                    localStorage.removeItem('cart');
                    localStorage.setItem('cart', JSON.stringify(tmp));
                    commit('changeCart', JSON.stringify(tmp));
                    commit('changeCount', initialCount(tmp));
                    commit('changeTotal', total(tmp));
                } else {
                    const tmp2 = {};
                    tmp2[opt.slug] = (opt.attribute !== null) ? [response.data] : response.data;
                    localStorage.setItem('cart', JSON.stringify(tmp2));
                    commit('changeCart', JSON.stringify(tmp2));
                    commit('changeCount', 1);
                    commit('changeTotal', total(tmp2));
                }
                // open drawer
                commit('openDrawer', true);
            })
            .catch((error) => {
                console.log(error);
            })
        },
        removeItem({commit}, opt) {
            if (localStorage.getItem('cart')) {
                const tmp_cart = JSON.parse(localStorage.getItem('cart'));
                var newCart = {};
                if (opt.index !== null) {
                    Object.entries(tmp_cart).forEach(([key, value]) => {
                        if (key === opt.slug) (value.length !== 1) ? value.splice(opt.index, 1) : delete tmp_cart[opt.slug];
                    });
                    newCart = tmp_cart;
                } else {
                    newCart = Object.keys(tmp_cart).reduce((object, key) => {
                        if (key !== opt.slug) object[key] = tmp_cart[key];
                        return object
                    }, {})
                }

                localStorage.removeItem('cart');
                localStorage.setItem('cart', JSON.stringify(newCart));
                commit('changeCart', JSON.stringify(newCart));
                commit('changeCount', initialCount(newCart));
                commit('changeTotal', total(newCart));
            }
            // closed drawer
            commit('openDrawer', false);
        },
        // change quantity
        changeQuantity({commit}, item) {
            const up_cart = JSON.parse(localStorage.getItem('cart'));
            Object.entries(up_cart).forEach(([key, value]) => {
                if (key === item.slug) {
                    if (Array.isArray(value)) {
                        value[item.index].quantity = item.quantity;
                    } else {
                        value.quantity = item.quantity;
                    }
                }
            });
            /* const slug_p = item.slug;
            const item_p = up_cart[slug_p];
            item_p.quantity = item.quantity; */

            localStorage.removeItem('cart');
            localStorage.setItem('cart', JSON.stringify(up_cart));
            commit('changeCart', JSON.stringify(up_cart));
            commit('changeTotal', total(up_cart));
        }
    },
    getters: {
    }
}


/* import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        shop: {
            maincolor: '',
            secondaryColor: '',
            btnColor: '',
            textColor: true
        }
    },
    mutations: {
        changeMainColor (state, color) {
            state.shop.maincolor = color
        },
        changeSecondaryColor (state, color) {
            state.shop.secondaryColor = color
        },
        changeBtnColor (state, color) {
            state.shop.btnColor = color
        },
        changeTextColor (state, color) {
            state.shop.textColor = color
        }
    },
    actions: {
        SettingShop({commit}, setting) {
            commit('changeMainColor', setting.main_color);
            commit('changeSecondaryColor', setting.secon_color);
            commit('changeBtnColor', setting.btn_color);
            commit('changeTextColor', setting.text_dark);
        }
    },
    modules: {
    }
}) */