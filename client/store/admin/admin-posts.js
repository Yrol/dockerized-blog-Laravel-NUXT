export const state = () => ({
  totalPosts:0,
  perPagePosts:0,
  posts:[],
  currentSortKey: null
})

export const getters = {
  totalPosts:(state) => {
    return state.totalPosts
  },
  perPagePosts:(state) => {
    return state.perPagePosts
  },
  allPosts:(state) => {
    return state.posts
  },
  postStatus:(state) => (id) => {
    if(!state.posts) {
      return
    }
    let post = state.posts.find(post => post.id == id)
    return post.is_live;
  },
  post:(state) => (slug) => {
    let post = state.posts.find(post => post.slug == slug)
    return post;
  }
}

export const mutations = {
  SET_POSTS(state, payload, sortKey = null){

    if (payload.length > 0 ) {
      sortPosts(state, payload, sortKey);
    }
  },
  SET_POST(state, payload) {
    state.posts.push(payload)
    state.totalPosts++;

    sortPosts(state, state.posts, 'acs_id')
  },
  SET_TOTAL(state, payload){
    state.totalPosts = payload
  },
  SET_PER_PAGE(state, payload){
    state.perPagePosts = payload
  },
  SET_POST_STATUS(state, payload){
    let post = state.posts.find(post => post.id === payload.id)
    post.is_live = payload.state
  },
  UPDATE_POST(state, payload){
    state.posts[state.posts.findIndex(post => post.id === payload.id)] = payload
  },
  DELETE_POST(state, payload){
    let postIndex = state.posts.findIndex(post => post.id === payload.id)
    state.posts.splice(postIndex, 1)

    if(state.totalPosts > 0){
      state.totalPosts--;
    }
  }
}

export const actions = {
  posts({commit}, payload){
    if(payload && payload.hasOwnProperty('data')){
      payload = payload.data
    }
    commit('SET_POSTS', payload)
  },
  totalPosts({ commit}, payload){
    commit('SET_TOTAL', payload)
  },
  perPagePosts({ commit}, payload){
    commit('SET_PER_PAGE', payload)
  },
  postStatus({commit}, payload){
    if(payload && payload.hasOwnProperty('id') && payload.hasOwnProperty('state')){
      commit('SET_POST_STATUS', payload);
    }
  },
  deletePost({commit}, payload){
    if(payload && payload.hasOwnProperty('id')){
      commit('DELETE_POST', payload);
    }
  },
  savePost({commit}, payload){
    if(payload && payload.hasOwnProperty('id')){
      commit('SET_POST', payload);
    }
  },
  updatePost({commit}, payload){
    if(payload && payload.hasOwnProperty('id')){
      commit('UPDATE_POST', payload)
    }
  },

  clear({commit}){
    commit('SET_TOTAL', 0)
    commit('SET_PER_PAGE', 0)
    commit('SET_POSTS', [])
  }
}

const sortPosts = (state, payload, sortKey = null) => {
  switch(sortKey) {
    case "acs_id":
      state.currentSortKey = 'acs_id'
      state.posts = payload.sort((a, b) => Number(a.id) - Number(b.id));
      break;
    default://desc ID
      state.currentSortKey = null
      state.posts = payload.sort((a, b) => Number(b.id) - Number(a.id));
  }
}
