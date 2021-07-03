export const state = () => ({
  totalKeyValues:0,
  keyValues:[],
})

export const getters = {
  totalKeyValues:(state) => {
    return state.totalKeyValues
  },
  allKeyValues:(state) => {
    return state.keyValues
  },
}

export const mutations = {
  SET_KEY_VALUES(state, payload, sortKey = null){
    state.keyValues = payload
  },
  SET_KEY_VALUE(state, payload) {
    state.keyValues.push(payload)
    state.totalKeyValues++;

    sortKeyValues(state, state.keyValues)
  },
  SET_TOTAL(state, payload){
    state.totalKeyValues = payload
  },

  UPDATE_KEY_VALUE(state, payload){
    state.keyValues[state.keyValues.findIndex(keyValue => keyValue.id === payload.id)] = payload
  },

  DELETE_KEY_VALUE(state, slug){
    let keyValueIndex = state.keyValues.findIndex(keyValue => keyValue.slug === slug)
    state.keyValues.splice(keyValueIndex, 1)

    if(state.totalKeyValues > 0){
      state.totalKeyValues--;
    }
  }
}

export const actions = {
  keyValues({commit}, payload){
    commit('SET_KEY_VALUES', payload)
  },
  totalKeyValues({ commit}, payload){
    commit('SET_TOTAL', payload)
  },

  saveKeyValue({commit}, payload){
    commit('SET_KEY_VALUE', payload);
  },

  updateKeyValue({commit}, payload){
    commit('UPDATE_KEY_VALUE', payload);
  },

  deleteKeyValue({commit}, slug){
    commit('DELETE_KEY_VALUE', slug);
  },

  clear({commit}){
    commit('SET_TOTAL', 0)
    commit('SET_KEY_VALUES', [])
  }
}


const sortKeyValues = (state, payload, sortKey = null) => {
  switch(sortKey) {
    case "acs_id":
      state.currentSortKey = 'acs_id'
      state.keyValues = payload.sort((a, b) => Number(a.id) - Number(b.id));
      break;
    default://desc ID
      state.currentSortKey = null
      state.keyValues = payload.sort((a, b) => Number(b.id) - Number(a.id));
  }
}
