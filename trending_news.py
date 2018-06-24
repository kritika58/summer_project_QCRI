import csv
from newsapi import NewsApiClient
api = NewsApiClient(api_key='9c3333c4645941b991df10014e2f8a8d')



s=api.get_top_headlines(sources='bbc-news')
print(len(s))
t=s['articles']
print(len(t))
print(t[0]['description'])
print(t[0]['title'])
print(t[0]['url'])
print(t[0]['author'])
print(t[0]['urlToImage'])
