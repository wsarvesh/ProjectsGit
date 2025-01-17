import json
from channels.generic.websocket import AsyncWebsocketConsumer
from channels.db import database_sync_to_async
from .models import *
import random



# 0 - Message
# 1 - Add
# 2 - Remove
# 3 - Roll-btn
# 4 - Roll-value



class ChatConsumer(AsyncWebsocketConsumer):
    @database_sync_to_async
    def get_count(self, name):
        return int(Room.objects.filter(name=name)[0].count)

    @database_sync_to_async
    def add_count(self, name):
        count = int(Room.objects.filter(name=name)[0].count)
        Room.objects.filter(name=name).update(count=str(count+1))
        return 0

    @database_sync_to_async
    def del_count(self, name):
        count = int(Room.objects.filter(name=name)[0].count)
        Room.objects.filter(name=name).update(count=str(count-1))
        return 0

    @database_sync_to_async
    def add_user(self, name, channel_name):
        User.objects.filter(name=name).update(channel_name=channel_name, tag="1")
        return 0

    @database_sync_to_async
    def del_user(self, name, channel_name):
        User.objects.filter(name=name).update(channel_name="", tag="-1")
        return 0

    @database_sync_to_async
    def roll(self, name):
        room = Room.objects.filter(name=name)
        id = room[0].game
        game = Game.objects.get(id=id)
        if game.player_count == game.type:
            return game
        return 0

    @database_sync_to_async
    def get_name(self, id):
        user = User.objects.get(id=id)
        return user.name

    @database_sync_to_async
    def change_turn(self, id):
        game = Game.objects.get(id=id)
        turn = (int(game.turn) + 1) % int(game.type)
        Game.objects.filter(id=id).update(turn=str(turn))
        return 1

    @database_sync_to_async
    def change_roll(self, id, roll):
        game = Game.objects.get(id=id)
        curr_loc_all = game.roll.split("#")
        curr_loc = curr_loc_all[int(game.turn)]
        curr_color = game.color.split("#")
        curr_color = curr_color[int(game.turn)]
        new_loc = (int(curr_loc) + roll) % 28
        curr_loc_all[int(game.turn)] = str(new_loc)
        Game.objects.filter(id=id).update(roll="#".join(curr_loc_all))
        return curr_loc, curr_color, new_loc

    @database_sync_to_async
    def get_turn(self, id):
        return int(Game.objects.get(id=id).turn)

    async def connect(self):
        self.room_name = self.scope['url_route']['kwargs']['room_name']
        self.room_group_name = 'chat_%s' % self.room_name

        # Join room group
        await self.channel_layer.group_add(
            self.room_group_name,
            self.channel_name
        )

        await self.accept()
        await self.add_count(self.room_name)
        await self.add_user(self.scope["session"]["name"], self.channel_name)
        game = await self.roll(self.room_name)
        print("game",game)

        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'tag': 1,
                'name':self.scope["session"]["name"],
            }
        )

        if game != 0:
            player = game.player.split("#")
            turn = player[int(game.turn)]
            name = await self.get_name(turn)

            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'chat_message',
                    'tag':3,
                    'roll':str(name)
                }
            )


    async def disconnect(self, close_code):
        # Leave room group

        await self.del_count(self.room_name)
        count = await self.get_count(self.room_name)
        await self.del_user(self.scope["session"]["name"], self.channel_name)

        await self.channel_layer.group_send(
            self.room_group_name,
            {
                'type': 'chat_message',
                'message':self.scope["session"]["name"],
                'tag':2,
                'count':count
            }
        )

        await self.channel_layer.group_discard(
            self.room_group_name,
            self.channel_name
        )


    # Receive message from WebSocket
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        tag = text_data_json['tag']
        if tag == 3:
            curr_player = text_data_json['name']
            roll = text_data_json['roll']
            roll = random.randint(1,6)
            game = await self.roll(self.room_name)
            curr_loc, curr_color, new_loc = await self.change_roll(game.id, roll)
            await self.change_turn(game.id)
            game = await self.roll(self.room_name)
            player = game.player.split("#")
            turn = player[int(game.turn)]
            name = await self.get_name(turn)

            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'chat_message',
                    'tag':4,
                    'curr_player':curr_player,
                    'curr_loc':curr_loc,
                    'curr_color':curr_color,
                    'roll_value':roll,
                    'new_loc':new_loc
                }
            )
            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'chat_message',
                    'tag':3,
                    'roll':name
                }
            )
            return

        if tag == 0:
            message = text_data_json['message']

            await self.send(text_data=json.dumps({
                'type': "yo",
                'tag':0,
                'message': "sender"
            }))
            await self.channel_layer.group_send(
                self.room_group_name,
                {
                    'type': 'chat_message',
                    'tag':0,
                    'message': message,
                }
            )
            return

    # Receive message from room group
    async def chat_message(self, event):
        tag = event['tag']
        type = event['type']
        if tag == 0:
            message = event['message']
            count = await self.get_count(self.room_name)
            await self.send(text_data=json.dumps({
                'type': type,
                'tag':0,
                'message':message,
                'count':count,
            }))
            return

        if tag == 1:
            name = event['name']
            count = await self.get_count(self.room_name)
            await self.send(text_data=json.dumps({
                'type': type,
                'tag':tag,
                'count':count,
                'name':name,
            }))
            return

        if tag == 2:
            message = event['message']
            count = await self.get_count(self.room_name)
            await self.send(text_data=json.dumps({
                'type': type,
                'tag':tag,
                'count':count,
                'message':message,
            }))
            return

        if tag == 3:
            roll = event['roll']
            count = await self.get_count(self.room_name)
            await self.send(text_data=json.dumps({
                'type': type,
                'tag': tag,
                'count':count,
                'roll':roll
            }))
            return
        if tag == 4:
            roll_value = event['roll_value']
            curr_player = event['curr_player']
            curr_loc = event['curr_loc']
            curr_color = event['curr_color']
            new_loc = event['new_loc']
            count = await self.get_count(self.room_name)
            await self.send(text_data=json.dumps({
                'type': type,
                'tag': tag,
                'curr_player':curr_player,
                'curr_loc':curr_loc,
                'curr_color':curr_color,
                'roll_value':roll_value,
                'new_loc':new_loc
            }))
            return
        type = event['type']
        roll = event['roll']
        # count = event['count']
        name = event['name']
        count = await self.get_count(self.room_name)

        # Send message to WebSocket
        await self.send(text_data=json.dumps({
            'type': type,
            'message': message,
            'count':count,
            'name':name,
            'roll':roll
        }))
