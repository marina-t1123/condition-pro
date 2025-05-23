import {
    ChakraProvider,
    defaultSystem,
    HStack,
    Stack,
    Box,
    Text,
    Button,
    Center,
    Input,
    NativeSelectRoot,
    NativeSelectField,
    Table,
    Image
} from '@chakra-ui/react';
import React, { useState, useMemo, useEffect } from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
} from "../../../../src/components/ui/dialog";
import { Field } from '../../../../src/components/ui/field';
import { Link, useForm } from '@inertiajs/react';

const Index = (props) => {
    // 選手情報と種目・ポジション情報をprops内から分割代入でそれぞれ変数内に格納する形で取り出す
    const { athletes: initialAthletes, m_events } = props;

    //　useFormを設定
    const { data, setData, get, errors } = useForm({
        'athlete_name': '',
        'm_event_id': '',
        'm_event_position_id': ''
    });
    console.log(data);


    // 選手のstate管理の設定
    const [athleteList, setAthleteList] = useState(initialAthletes); //useStateの初期値に取得した選手情報(Arrayインスタンス)が格納されている変数を指定

    // useMemoの依存配列にathleteListを指定。初回レンダリング時とathleteListに変更があった場合に、以下の処理を実装。
    const expandedAthletes = useMemo(() => {
        // これからポジションごとの選手情報を配列に格納するために、変数に空配列を格納する
        const expandedAthleteList = [];

        // athleteList(現在の選手情報)から各選手に処理を行うために繰り返し処理を実施
        athleteList.forEach((athlete) => {
            // 選手に紐づくポジションごとに繰り返し処理を実施
            // 元々の選手情報を複製して、ポジションと種目を新しいプロパティとして追加して、変数に格納する
            athlete.m_event_positions.forEach((m_event_position) => {
                expandedAthleteList.push({
                    ...athlete,
                    position: m_event_position,
                    event: m_event_position.m_event
                });
            });
        });

        return expandedAthleteList;

    }, [athleteList]);

    // ポジションoptionのstate管理の設定
    const [positionOptions, setPositionOptions] = useState([]);
    console.log(positionOptions);

    // 種目optionが変更された場合の、ポジションoptionをセットする処理
    useEffect(() => {
        console.log('useEffectの処理実行');
        if (data.m_event_id) {
            console.log('検索処理start');
            // 種目に紐づくポジション・階級をm_events(props)から検索して取得
            const selectedEvent = m_events.find(event => event.id.toString() === data.m_event_id);
            console.log(selectedEvent);

            if (selectedEvent && selectedEvent.m_event_positions) {
                setPositionOptions(selectedEvent.m_event_positions);
            } else {
                setPositionOptions([]);
            }
        }

        // 種目が変更されたら、検索フォームstate(ポジション・階級の選択)をリセット
        setData('m_event_position_id', '');
    }, [data.m_event_id]);

    // 検索フォームの内容が変更された際の処理
    const handleChange = (e) => {
        setData({ ...data, [e.target.name]: e.target.value });
    }

    // 検索ボタンを押した際の処理
    const handleSubmit = (e) => {
        e.preventDefault();

        get(route('athlete.index'), {
            athlete_name: data.athlete_name,
            m_event_id: parseInt(data.m_event_id, 10),
            m_event_position_id: parseInt(data.m_event_position_id, 10)
        });

    }

    return (
        <ChakraProvider value={defaultSystem}>
            <>
                <CustomHeader />

                {/* メイン */}
                <Box className='main' width='90%' m='auto' bg='white' marginTop='20px' boxShadow='md'>
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle='2xl' m='20px'>選手一覧</Text>
                        <DialogRoot>
                            <DialogTrigger asChild>
                                <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem' w="10%">
                                    検索
                                </Button>
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <Center>
                                        <DialogTitle>選手検索</DialogTitle>
                                    </Center>
                                </DialogHeader>
                                <DialogBody>
                                    <form onSubmit={handleSubmit}>
                                        <Stack gap="4">
                                            <Field label="選手名">
                                                <Input
                                                    placeholder='選手名を入力してください'
                                                    type='text'
                                                    id='athlete_name'
                                                    name='athlete_name'
                                                    value={data.athlete_name}
                                                    onChange={handleChange}
                                                />
                                            </Field>
                                            {errors.athlete_name && <Text color="red.500">{errors.athlete_name}</Text>}
                                            <Field label="種目">
                                                <NativeSelectRoot>
                                                    <NativeSelectField placeholder='種目を選択してください' name='m_event_id' value={data.m_event_id} onChange={handleChange}>
                                                        {m_events.map((m_event, i) => <option key={i} value={m_event.id}>{m_event.event_name}</option>)}
                                                    </NativeSelectField>
                                                </NativeSelectRoot>
                                            </Field>
                                            {errors.m_event_id && <Text color="red.500">{errors.m_event_id}</Text>}
                                            <Field label="ポシジョン・階級">
                                                <NativeSelectRoot>
                                                    <NativeSelectField
                                                        placeholder='ポジション・階級を選択してください'
                                                        name='m_event_position_id'
                                                        value={data.m_event_position_id}
                                                        onChange={handleChange}
                                                        disabled={!data.m_event_id}
                                                    >
                                                        {positionOptions.map((positionOption, i) => <option key={i} value={positionOption.id}>{positionOption.event_position_name}</option>)}
                                                    </NativeSelectField>
                                                </NativeSelectRoot>
                                            </Field>
                                            {errors.m_event_position_id && <Text color="red.500">{errors.m_event_position_id}</Text>}
                                        </Stack>
                                        <Center>
                                            <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='50%' mt='2rem'>検索</Button>
                                        </Center>
                                    </form>
                                </DialogBody>
                                <DialogCloseTrigger />
                            </DialogContent>
                        </DialogRoot>
                        <Button as={Link} href={`/athletes`} color='white' bg='gray.500' p='5'>リセット</Button>
                        <Button as={Link} href={`/athletes/create`} bg='orange.400' p="1rem">
                            選手を登録する
                        </Button>
                    </HStack>
                </Box>

                {/* テーブル */}
                <Table.ScrollArea w='90%' m='auto' marginY="2rem" h='70vh' border='1px solid' borderColor='gray.200' p='1rem'>
                    <Table.Root>
                        <Table.Header position='sticky' top='0' zIndex='1' bg='gray.400'>
                            <Table.Row>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>選手名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>チーム名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>種目名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>ポジション・階級</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>詳細</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>編集</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom='2px solid' borderColor="gray.400" textAlign='center' fontSize='md'>傷病情報</Table.ColumnHeader>
                            </Table.Row>
                        </Table.Header>

                        <Table.Body>
                            {/*  ポジションごとに格納した選手情報の配列から各選手情報を取り出す */}
                            {expandedAthletes.map((athlete, i) =>
                                <Table.Row key={i}>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300" >
                                        {athlete.name}
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300" >
                                        {athlete.team.team_name}
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300" >
                                        {athlete.event.event_name}
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300" >
                                        {athlete.position.event_position_name}
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href={`/athletes/show/${athlete.id}/${athlete.position.id}`}>
                                            <Center>
                                                <Image src="img/athlete.png"></Image>
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href={`/athletes/edit/${athlete.id}/${athlete.position.id}`}>
                                            <Center>
                                                <Image src="img/edit.png"></Image>
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                    <Table.Cell textAlign='ceanter' borderBottom="1px solid" borderColor="gray.300">
                                        <Link variant='plain' href={`/athletes/edit/${athlete.id}/${athlete.position.id}`}>
                                            <Center>
                                                <Image src="img/injury_infomation.png"></Image>
                                            </Center>
                                        </Link>
                                    </Table.Cell>
                                </Table.Row>
                            )}

                        </Table.Body>
                    </Table.Root>
                </Table.ScrollArea>

            </>
        </ChakraProvider>
    )
}
export default Index;
