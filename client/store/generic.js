export const state = () => ({
  categoriesList:[]
})

export const getters = {
  categoriesList: (state) => {
    return state.categoriesList
  }
}

export const mutations = {
  SET_CATEGORIES_LIST(state, payload) {
    state.categoriesList = payload
  },
}

export const actions = {
  categoriesList({commit}, payload){
    commit('SET_CATEGORIES_LIST', payload)
  },
  clear({commit}){
    commit('SET_CATEGORIES_LIST', [])
  }
}
