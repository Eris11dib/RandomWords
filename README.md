# RandomWords
a semplificated RandomWords plugin

```yaml
---
time_message: 1000
words:
- select
- your
- words
rewards:
  - "306:0:1"
  - "308:0:1"
  - 1500
max_players: 1
...
```

# Configuration

1) time_message: 1000 => The maximum time in ticks to write a word (20 ticks = 1s)
2) words: means all the minigames's words that the players have to type faster than others
3) rewards: this section is dedicated to rewards, if you wanna gave some items, insert the id:meta:count, also you can addMoney to players just by insert the ammount (EconomyAPI needed)
4) max_players: how many players you want to start the minigame
