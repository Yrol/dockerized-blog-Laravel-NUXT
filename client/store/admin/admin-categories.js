export const state = () => ({
  totalCategories:0,
  categories:[],
  currentSortKey: null
})

export const getters = {
  totalCategories:(state) => {
    return state.totalCategories
  },
  allCategories:(state) => {
    return state.categories
  },
}

export const mutations = {
  SET_CATEGORIES(state, payload, sortKey = null){
    state.categories = payload
  },
  SET_CATEGORY(state, payload) {
    state.categories.push(payload)
    state.totalCategories++;

    sortCategories(state, state.categories)
  },
  SET_TOTAL(state, payload){
    state.totalCategories = payload
  },

  UPDATE_CATEGORY(state, payload){
    state.categories[state.categories.findIndex(category => category.id === payload.id)] = payload
  },

  DELETE_CATEGORY(state, payload) {

  }
}

export const actions = {
  categories({commit}, payload){
    commit('SET_CATEGORIES', payload)
  },
  totalCategories({ commit}, payload){
    commit('SET_TOTAL', payload)
  },

  saveCategory({commit}, payload){
    commit('SET_CATEGORY', payload);
  },

  updateCategory({commit}, payload){
    commit('UPDATE_CATEGORY', payload);
  },

  clear({commit}){
    commit('SET_TOTAL', 0)
    commit('SET_CATEGORIES', [])
  }
}

const sortCategories = (state, payload, sortKey = null) => {
  switch(sortKey) {
    case "acs_id":
      state.currentSortKey = 'acs_id'
      state.categories = payload.sort((a, b) => Number(a.id) - Number(b.id));
      break;
    default://desc ID
      state.currentSortKey = null
      state.categories = payload.sort((a, b) => Number(b.id) - Number(a.id));
  }
}
