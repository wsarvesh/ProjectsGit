from django.shortcuts import render
from django.http import HttpResponse, HttpResponseRedirect
from .forms import *
from .models import *
import random

def index(request):
    id = [i for i in range(28)]
    data = "QWERTYUIOPASDFGHJKLZXCVBNM?@"
    data = ['Start','Delhi','Rio','Bangkok','Harbor','Madrid','Cairo','Random','Jakarta','Berlin']
    data = data + ['Moscow','Railway','Toronto','Seoul','Jail','Zurich','Riyadh','Sydney','Electric Co.','Beijing','Dubai']
    data = data + ['Auction','Paris','Hong Kong','London','Airport','Tokyo','New York']
    bgs = ["#FFFFFF","#8ebc42","#8ebc42","#58b4f5","#C2FBFF","#58b4f5","#58b4f5","#FFFFFF","#af3e6a","#af3e6a","#f39704","#C2FBFF","#f39704","#f39704"]
    bgs = bgs + ["#FFFFFF","#1b8f6c","#1b8f6c","#905422","#C2FBFF","#905422","#905422","#FFFFFF","#6f3dc2","#6f3dc2","#f45631","#C2FBFF","#f45631","#f45631"]
    tags = [2,0,0,0,1,0,0,2,0,0,0,1,0,0,2,0,0,0,1,0,0,2,0,0,0,1,0,0]
    Board.objects.all().delete()
    for i in range(28):
        b = random.randrange(100,900,50)
        r = b//2
        s = b - 50
        Board.objects.create(id=id[i], name=data[i], color=bgs[i], buy=b, rent=r, tag=tags[i], sell=s)
    if request.method == "POST":
        lf = LoginForm(request.POST)
        # print(lf, lf.is_valid())
        if lf.is_valid():
            uname = lf.cleaned_data["uname"]
            rname = lf.cleaned_data["rname"]
            password = lf.cleaned_data["password"]
            auth = Room.objects.filter(name=rname, password=password)
            if auth.count() == 1:
                user = User.objects.filter(name=uname)
                if user.count() == 1 and user[0].tag == "-1":
                    request.session['name'] = uname
                    return HttpResponseRedirect('/chat/' + rname + '/')
                User.objects.create(name=uname, channel_name="", tag="-1")
                request.session['name'] = uname
                return HttpResponseRedirect('/chat/' + rname + '/')
            error = "Invalid Room Name or password"
            return render(request, 'chat/index.html', {'error':error})

    lf = LoginForm()
    return render(request, 'chat/index.html')

# def room(request, room_name):
#     if 'name' in request.session:
#         return render(request, 'chat/room.html', {
#             'room_name': room_name,
#             'name':request.session['name']
#             })
#     return render(request, 'chat/index.html')

def room(request, room_name):
    if 'name' in request.session:
        id = [[7,8,9,10],[11,12,13,14],[6,15],[5,16],[4,17],[3,18],[2,19],[1,20],[0,27,26,25],[24,23,22,21]]


        # FORM DATA

        # places = ['Start','Delhi','Rio','Bangkok','Harbor','Madrid','Cairo','Random','Jakarta','Berlin']
        # places = places + ['Moscow','Railway','Toronto','Seoul','Jail','Zurich','Riyadh','Sydney','Electric Co.','Beijing','Dubai']
        # places = places + ['Auction','Paris','Hong Kong','London','Airport','Tokyo','New York']
        # bgs = ["#FFFFFF","#8ebc42","#8ebc42","#58b4f5","#C2FBFF","#58b4f5","#58b4f5","#FFFFFF","#af3e6a","#af3e6a","#f39704","#C2FBFF","#f39704","#f39704"]
        # bgs = bgs + ["#FFFFFF","#1b8f6c","#1b8f6c","#905422","#C2FBFF","#905422","#905422","#FFFFFF","#6f3dc2","#6f3dc2","#f45631","#C2FBFF","#f45631","#f45631"]
        # tags = [2,0,0,0,1,0,0,2,0,0,0,1,0,0,2,0,0,0,1,0,0,2,0,0,0,1,0,0]

        board = Board.objects.all()
        # places = []
        # bgs = []
        # tags = []
        #
        # for i in board:
        #     places.append(i.name)
        #     bgs.append(i.color)
        #     tags.append(i.tag)
        places = list(Board.objects.values_list('name', flat=True))
        bgs = list(Board.objects.values_list('color', flat=True))
        tags = [int(i) for i in list(Board.objects.values_list('tag', flat=True))]
        prices = list(Board.objects.values_list('buy', flat=True))
        # print(places)

        # print(places, bgs, tags)

        place = {}
        bg = {}
        tag = {}
        price = {}
        for i in range(28):
            place[i] = places[i]
            bg[i] = bgs[i]
            tag[i] = tags[i]
            price[i] = prices[i]

        # FORM DATA

        info = []
        dummy = {"num":-1}
        for i in id:
            if len(i) == 2:
                one = {"num":i[0],'place':place[i[0]],'bgcolor':bg[i[0]],'tag':tag[i[0]], 'price':price[i[0]]}
                two = {"num":i[1],'place':place[i[1]],'bgcolor':bg[i[1]],'tag':tag[i[1]], 'price':price[i[1]]}
                info.append([one,dummy,dummy,dummy])
                info.append([dummy,dummy,dummy,two])
            else:
                temp = []
                for x in i:
                    temp.append({"num":x,'place':place[x],'bgcolor':bg[x],'tag':tag[x], 'price':price[x]})
                info.append(temp)
    return render(request, 'chat/room.html', {'room_name': room_name,'info':info, 'name':request.session['name']})
# Create your views here.
