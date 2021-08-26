export const generateSeoMeta = (data) => [
  {
    hid: 'og:title',
    property: 'og:title',
    content: data.title
  },
  {
    hid: 'description',
    name: 'description',
    content: data.description
  },
  {
    hid: 'og:description',
    property: 'og:description',
    content: data.description,
  },
  {
    hid: 'og:url',
    property: 'og:url',
    content: data.url,
  },
]
