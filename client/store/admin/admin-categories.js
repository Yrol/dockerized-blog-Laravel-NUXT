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
    state.categories[state.categories.findIndex(category => category.slug === payload.oldSlug)] = payload.latestData
  },

  DELETE_CATEGORY(state, payload) {
    let categoryIndex = state.categories.findIndex(category => category.slug === payload.slug)
    state.categories.splice(categoryIndex, 1)

    if(state.totalCategories > 0){
      state.totalCategories--;
    }
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
    if(payload && payload.hasOwnProperty('slug')){
      commit('SET_CATEGORY', payload);
    }
  },

  updateCategory({commit}, payload){
    if(payload.latestData && payload.latestData.hasOwnProperty('slug'))
    commit('UPDATE_CATEGORY', payload);
  },

  deleteCategory({commit}, payload){
    if(payload && payload.hasOwnProperty('slug')){
      commit('DELETE_CATEGORY', payload);
    }
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
      state.categories = payload.sort((a, b) => new Date(a.updated_at_dates.updated_at_format_1) - new Date(b.updated_at_dates.updated_at_format_1));
      break;
    default://desc ID
      state.currentSortKey = null
      state.categories = payload.sort((a, b) => new Date(b.updated_at_dates.updated_at_format_1) - new Date(a.updated_at_dates.updated_at_format_1));
  }
}
