import axios from 'axios'

export default {
  state: {
    tables: []
  },
  mutations: {
    setTables (state, tables) {
      state.tables = tables
    }
  },
  actions: {
    async fetch ({ commit }) {
      try {
        const { data } = await axios.get('/admin/api/database')
        commit('setTables', data)
        return true
      } catch (error) {
        alert(error)
      }
    }
  },
  namespaced: true
}
