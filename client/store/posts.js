export const state = () => ({
  totalPosts:0,
  perPagePosts:0
})

export const getters = {
  all:(state) => {
    return [state.totalPosts, state.perPagePosts]
  },
  totalPosts: (state) => {
    return state.totalPosts
  },
  perPagePosts: (state) => {
    return state.perPagePosts
  }
}

export const mutations = {
  SET_TOTAL(state, payload) {
    state.totalPosts = payload
  },

  SET_PER_PAGE(state, payload){
    state.perPagePosts = payload
  }
}

export const actions = {
  totalPosts({ commit}, payload){
    if(payload && payload.hasOwnProperty('meta')){
      payload = payload.meta.total
    }
    commit('SET_TOTAL', payload)
  },
  perPagePosts({ commit}, payload){
    if(payload && payload.hasOwnProperty('meta')){
      payload = payload.meta.per_page
    }
    commit('SET_PER_PAGE', payload)
  },
  clear({commit}){
    commit('SET_TOTAL', 0)
    commit('SET_PER_PAGE', 0)
  }
}
